<?php

namespace App\Livewire\Web;

use App\Models\Address;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use App\Services\CartService;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CheckOutComponent extends Component
{
    public $cart = [];
    public $subtotal = 0;
    public $shipping;
    public $shippingCost = 0;
    public $total = 0;
    public $coupon = null;
    public $activeTab = "shipping";
    public $payment_method = 'cod';
    public $address = null;
    public $activePayment = 'cod';
    public $placing = false;
    public $isAuthenticated = false;
    public $showLoginModal = false;

    protected $listeners = [
        'userLoggedIn' => 'onUserLoggedIn',
        'couponApplied' => 'couponDone',
        'goTotab' => 'tabShow',
        'addressSaved' => 'loadAddressFromSession',
        'cartUpdated' => 'loadCart'
    ];

    public $paymentMethods = [
        [
            'key' => 'cod',
            'name' => 'Cash on Delivery',
            'description' => 'Pay when your order arrives at your doorstep.',
            'icon' => 'fa-solid fa-hand-holding-dollar'
        ],
    ];

    public function mount()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            $this->isAuthenticated = false;
            $this->showLoginModal = true;
            $this->dispatch('force-login', ['returnUrl' => route('web-check-out')]);
            return;
        }

        $this->isAuthenticated = true;
        
        // Check if cart is empty
        $cartService = app(CartService::class);
        if ($cartService->isEmpty()) {
            return redirect()->route('web-cart')->with('error', 'Your cart is empty. Add items before checkout.');
        }

        $this->initializeCheckout();
    }

    public function onUserLoggedIn()
    {
        $this->isAuthenticated = true;
        $this->showLoginModal = false;
        $this->initializeCheckout();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Welcome back! Continue with your order.']);
    }

    private function initializeCheckout()
    {
        $this->shipping = ShippingMethod::where('is_active', true)
            ->first();
            
        $this->shippingCost = $this->shipping?->cost ?? 0;
        $this->payment_method = 'cod';
        $this->activePayment = 'cod';
        $this->loadCart();
        $this->couponDone();
        $this->loadAddressFromSession();
        
        // Set default tab
        $this->activeTab = 'shipping';
    }

    public function tabShow($tab)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            $this->dispatch('force-login');
            return;
        }

        // Step guards
        if ($tab === 'payment') {
            if (!$this->hasSelectedAddress()) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Please select or save a shipping address first.']);
                return;
            }
        }

        if ($tab === 'review') {
            if (!$this->hasSelectedAddress()) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Shipping address missing.']);
                return;
            }
            $this->loadAddressFromSession();
            $this->activePayment = $this->payment_method;
        }

        // Set the active tab
        $this->activeTab = $tab;
    }

    public function hasSelectedAddress(): bool
    {
        $addrId = session('activeAddress');
        if (!$addrId) return false;
        return Address::where('id', $addrId)->exists();
    }

    public function loadCart()
    {
        $cartService = app(CartService::class);
        $rawCart = $cartService->getCart();

        $items = $rawCart instanceof \Illuminate\Support\Collection
            ? $rawCart->values()->all()
            : (array) $rawCart;

        if (empty($items)) {
            $this->cart = [];
            $this->subtotal = 0;
            $this->total = $this->shippingCost;
            return;
        }

        $productIds = collect($items)->pluck('product_id')->unique();
        $products = Product::with(['variants', 'media', 'prices'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $this->cart = collect($items)->map(function ($item) use ($products) {
            $product = $products->get($item['product_id']);
            $variant = $product?->variants?->firstWhere('id', $item['variant_id']);
            $price = $variant?->price ?? ($product?->prices?->final_price ?? 0);

            return [
                'product_id'      => $item['product_id'],
                'variant_id'      => $item['variant_id'] ?? null,
                'quantity'        => $item['quantity'],
                'qty'             => $item['quantity'],
                'name'            => $product?->name,
                'sku'             => $product?->sku,
                'image'           => optional($product?->media?->first())->file_path ?? null,
                'variant_sku'     => $variant?->sku,
                'variant_options' => $variant?->options,
                'discount'        => 0,
                'price'           => $price,
                'product'         => $product,
                'variant'         => $variant,
            ];
        })->toArray();

        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return ($item['price'] * $item['qty']);
        });

        $discount = session('applied_coupon.discount', 0);
        $subtotalAfterDiscount = max(0, $this->subtotal - $discount);

        $this->total = $subtotalAfterDiscount + ($this->shippingCost ?? 0);
    }

    public function couponDone()
    {
        $this->loadCart();
    }

    public function gotoPayment()
    {
        if (!Auth::check()) {
            $this->dispatch('force-login');
            return;
        }

        if (!$this->hasSelectedAddress()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Select or save an address first.']);
            return;
        }
        
        $this->activeTab = 'payment';
    }

    public function goToReview()
    {
        // Validate that we have everything needed
        if (!Auth::check()) {
            $this->dispatch('force-login');
            return;
        }

        if (!$this->hasSelectedAddress()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Shipping address missing.']);
            return;
        }

        // Always use COD as default
        $this->payment_method = 'cod';
        session(['pay_method' => 'cod']);
        $this->activePayment = 'cod';
        
        // Load fresh data
        $this->loadAddressFromSession();
        $this->loadCart();
        
        // Switch to review tab
        $this->activeTab = 'review';
        
        // Dispatch event for UI update
        $this->dispatch('tab-changed', ['tab' => 'review']);
    }

    public function loadAddressFromSession()
    {
        $addrId = session('activeAddress');
        $this->address = $addrId ? Address::find($addrId) : null;
    }

    private function generateInvoiceNo()
    {
        $year = now()->year;
        $prefix = 'INV-' . $year . '-';
        
        $latest = Order::where('invoice_no', 'LIKE', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($latest) {
            $lastNumber = intval(substr($latest->invoice_no, -6));
            $number = $lastNumber + 1;
        } else {
            $number = 1;
        }

        return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function placeOrder()
    {
        if ($this->placing) return;
        $this->placing = true;

        try {
            if (!Auth::check()) {
                $this->dispatch('force-login');
                throw ValidationException::withMessages(['auth' => 'Please login to place the order.']);
            }

            if (!$this->hasSelectedAddress()) {
                throw ValidationException::withMessages(['address' => 'No shipping address selected.']);
            }

            $pay = 'cod';
            session(['pay_method' => 'cod']);

            $this->loadCart();
            if (empty($this->cart)) {
                throw ValidationException::withMessages(['cart' => 'Cart is empty.']);
            }

            DB::beginTransaction();

            $invoiceNo = $this->generateInvoiceNo();
            $address = Address::findOrFail(session('activeAddress'));

            $discountAmount = session('applied_coupon.discount', 0);
            $subtotal = $this->subtotal;
            $grandTotal = max(0, $subtotal - $discountAmount) + ($this->shippingCost ?? 0);

            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $address->name,
                'customer_phone' => $address->phone,
                'customer_email' => auth()->user()->email ?? 'guest@example.com',
                'shipping_address' => trim($address->address_line_1 . ' ' . ($address->address_line_2 ?? '')),
                'shipping_city' => $address->city,
                'shipping_state' => $address->province ?? null,
                'shipping_postal_code' => $address->postal_code ?? null,
                'country' => $address->country ?? 'Pakistan',
                'shipping_method_id' => $this->shipping?->id,
                'shipping_method_name' => $this->shipping?->name,
                'shipping_charges' => $this->shippingCost,
                'payment_method' => $pay,
                'payment_status' => 'pending',
                'coupon_id' => session('applied_coupon.id'),
                'coupon_code' => session('applied_coupon.code'),
                'discount_amount' => $discountAmount,
                'offer_id' => session('applied_coupon.offer_id'),
                'subtotal' => $subtotal,
                'tax_amount' => 0,
                'grand_total' => $grandTotal,
                'total_items' => array_sum(array_column($this->cart, 'qty')),
                'invoice_no' => $invoiceNo,
                'invoice_date' => now(),
                'status' => 'pending',
                'order_date' => now(),
            ]);

            foreach ($this->cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'],
                    'product_image' => $item['image'],
                    'variant_sku' => $item['variant_sku'] ?? null,
                    'variant_options' => $item['variant_options'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'discount_amount' => $item['discount'] ?? 0,
                    'total' => ($item['price'] * $item['qty']) - ($item['discount'] ?? 0),
                ]);

                if (!empty($item['variant']) && $item['variant'] instanceof \Illuminate\Database\Eloquent\Model) {
                    $item['variant']->decrement('stock', $item['qty']);
                }
                if (!empty($item['product']) && $item['product'] instanceof \Illuminate\Database\Eloquent\Model) {
                    $item['product']->decrement('stock', $item['qty']);
                }
            }

            app(CartService::class)->clear();

            DB::commit();

            $this->dispatch('show-thankyou');
            return redirect()->route('order.detail', $order->invoice_no);

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->placing = false;
            
            if ($e instanceof ValidationException) {
                throw $e;
            }
            
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Could not place order. Please try again.']);
        }
    }

    public function render()
    {
        // If not authenticated, show login prompt
        if (!$this->isAuthenticated) {
            return view('livewire.web.checkout-login-prompt')
                ->extends('layouts.web')
                ->section('web-content');
        }

        return view('livewire.web.check-out-component')
            ->extends('layouts.web')
            ->section('web-content');
    }
}