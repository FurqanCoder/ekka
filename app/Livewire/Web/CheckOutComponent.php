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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
    public $payment_method = null;
    public $address = null;
    public $activePayment = null;
    public $placing = false; // prevent double submit

    protected $listeners = [
        'userLoggedIn' => 'onUserLoggedIn',
        'couponApplied' => 'couponDone',
        'goTotab' => 'tabShow',
        'addressSaved' => 'loadAddressFromSession',
        'cartUpdated' => 'loadCart' // if other component emits cartUpdated
    ];

    public $paymentMethods = [
        [
            'key' => 'cod',
            'name' => 'Cash on Delivery',
            'description' => 'Pay when your order arrives at your doorstep.',
        ],
        [
            'key' => 'card',
            'name' => 'Credit/Debit Card',
            'description' => 'Secure online payment.',
            'disabled' => true,
        ],
    ];

    public function mount()
    {
        if (!Auth::check()) {
            // ask frontend to show login modal
            $this->dispatch('open-login');
        }

        $this->initializeCheckout();
    }

    private function initializeCheckout()
    {
        $this->shipping = ShippingMethod::latest()->first();
        $this->shippingCost = $this->shipping?->cost ?? 0;
        $this->loadCart();
        $this->couponDone();
        $this->loadAddressFromSession();
    }

    public function tabShow($tab)
    {
        // enforce step guards
        if ($tab === 'payment') {
            if (!$this->hasSelectedAddress()) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Please select or save a shipping address first.']);
                return;
            }
        }

        if ($tab === 'review') {
            if (!$this->payment_method && !session('pay_method')) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Please choose a payment method first.']);
                return;
            }
            // ensure address exists
            if (!$this->hasSelectedAddress()) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Shipping address missing.']);
                return;
            }
            // ensure we have fresh address loaded
            $this->loadAddressFromSession();
            $this->activePayment = session('pay_method') ?? $this->payment_method;
        }

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
                'image'           => optional($product?->media?->first())->file_name ?? null,
                'variant_sku'     => $variant?->sku,
                'variant_options' => $variant?->options,
                'discount'        => 0,
                'price'           => $price,
                'product'         => $product,
                'variant'         => $variant,
            ];
        })->toArray();

        // calculate subtotal
        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return ($item['price'] * $item['qty']);
        });

        // incorporate coupon if present
        $discount = session('applied_coupon.discount', 0);
        $subtotalAfterDiscount = max(0, $this->subtotal - $discount);

        $this->total = $subtotalAfterDiscount + ($this->shippingCost ?? 0);
    }

    public function couponDone()
    {
        // recalc totals when coupon applied
        $this->loadCart();
    }

    public function onUserLoggedIn()
    {
        $this->initializeCheckout();
    }

    public function gotoPayment()
    {
        // ensure selected address
        if (!$this->hasSelectedAddress()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Select or save an address first.']);
            return;
        }
        $this->activeTab = 'payment';
    }

    public function goToReview()
    {
        $this->validate([
            'payment_method' => 'required',
        ]);

        // store selected payment in session (so nested components & page reloads keep it)
        session(['pay_method' => $this->payment_method]);

        // ensure shipping present
        if (!$this->hasSelectedAddress()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Shipping address missing.']);
            return;
        }

        $this->activePayment = $this->payment_method;
        $this->activeTab = 'review';
        $this->loadAddressFromSession();
        $this->loadCart();
    }

    public function loadAddressFromSession()
    {
        $addrId = session('activeAddress');
        $this->address = $addrId ? Address::find($addrId) : null;
    }

    private function generateInvoiceNo()
    {
        $year = now()->year;

        $latest = Order::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $number = $latest ? intval(substr($latest->invoice_no, -6)) + 1 : 1;

        return 'INV-' . $year . '-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function placeOrder()
    {
        // prevent double clicking
        if ($this->placing) return;
        $this->placing = true;

        try {
            // validations
            if (!Auth::check()) {
                throw ValidationException::withMessages(['auth' => 'Please login to place the order.']);
            }

            if (!$this->hasSelectedAddress()) {
                throw ValidationException::withMessages(['address' => 'No shipping address selected.']);
            }

            $pay = session('pay_method') ?? $this->payment_method;
            if (!$pay) {
                throw ValidationException::withMessages(['payment' => 'Please select a payment method.']);
            }

            $this->loadCart(); // ensure fresh cart and totals
            if (empty($this->cart)) {
                throw ValidationException::withMessages(['cart' => 'Cart is empty.']);
            }

            DB::beginTransaction();

            $invoiceNo = $this->generateInvoiceNo();

            $address = Address::findOrFail(session('activeAddress'));

            // compute discount & totals fresh
            $discountAmount = session('applied_coupon.discount', 0);
            $subtotal = $this->subtotal;
            $grandTotal = max(0, $subtotal - $discountAmount) + ($this->shippingCost ?? 0);

            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name'        => $address->name,
                'customer_phone'       => $address->phone,
                'customer_email'       => auth()->user()->email,
                'shipping_address'     => trim($address->address_line_1 . ' ' . ($address->address_line_2 ?? '')),
                'shipping_city'        => $address->city,
                'shipping_state'       => $address->province ?? null,
                'shipping_postal_code' => $address->postal_code ?? null,
                'country'              => $address->country ?? 'Pakistan',
                'shipping_method_id'   => $this->shipping?->id,
                'shipping_method_name' => $this->shipping?->name,
                'shipping_charges'     => $this->shippingCost,
                'payment_method'       => $pay,
                'payment_status'       => 'pending',
                'coupon_id'            => session('applied_coupon.id'),
                'coupon_code'          => session('applied_coupon.code'),
                'discount_amount'      => $discountAmount,
                'offer_id'             => session('applied_coupon.offer_id'),
                'subtotal'             => $subtotal,
                'tax_amount'           => 0,
                'grand_total'          => $grandTotal,
                'total_items'          => array_sum(array_column($this->cart, 'qty')),
                'invoice_no'           => $invoiceNo,
                'invoice_date'         => now(),
                'status'               => 'pending',
            ]);

            // create order items and update stock
            foreach ($this->cart as $item) {
                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item['product_id'],
                    'variant_id'      => $item['variant_id'] ?? null,
                    'product_name'    => $item['name'],
                    'product_sku'     => $item['sku'],
                    'product_image'   => $item['image'],
                    'variant_sku'     => $item['variant_sku'] ?? null,
                    'variant_options' => $item['variant_options'] ?? null,
                    'price'           => $item['price'],
                    'quantity'        => $item['qty'],
                    'discount_amount' => $item['discount'] ?? 0,
                    'total'           => ($item['price'] * $item['qty']) - ($item['discount'] ?? 0),
                ]);

                // decrement stock safely
                if (!empty($item['variant']) && $item['variant'] instanceof \Illuminate\Database\Eloquent\Model) {
                    $item['variant']->decrement('stock', $item['qty']);
                }
                if (!empty($item['product']) && $item['product'] instanceof \Illuminate\Database\Eloquent\Model) {
                    $item['product']->decrement('stock', $item['qty']);
                }
            }

            // clear cart
            app(CartService::class)->clear();

            DB::commit();

            // Optionally: dispatch notifications here (email, admin alert)

            // redirect to success page
            return redirect()->route('checkout.success', $order->invoice_no);

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->placing = false;
            // bubble up validation messages if any
            if ($e instanceof ValidationException) {
                throw $e;
            }
            // log($e->getMessage()); // consider logging
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Could not place order. Try again.']);
            $this->dispatch('console-error', ['message' => $e->getMessage()]);
        }
    }

    public function thanks()
    {
        $this->dispatch('show-thankyou');
    }

    public function render()
    {
        return view('livewire.web.check-out-component')->extends('layouts.web')->section('web-content');
    }
}
