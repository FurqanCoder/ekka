<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ContactMessage;
use App\Models\ProductReview;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndexComponent extends Component
{
    public $stats = [];
    public $recentOrders = [];
    public $topProducts = [];
    public $recentCustomers = [];
    public $orderStatusCounts = [];
    public $monthlyRevenue = [];
    public $salesData = [];
    public $customerGrowth = [];

    // Define your order statuses
    protected $orderStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'];
    
    // Define completed statuses (for revenue calculations)
    protected $completedStatuses = ['delivered'];

    public function mount()
    {
        // Debug: Log all statuses
        $this->debugStatuses();
        
        $this->loadDashboardData();
    }

    public function debugStatuses()
    {
        // Get all orders with their statuses
        $orders = Order::select('id', 'status')->get();
        
        \Log::info('=== ORDER STATUS DEBUG ===');
        \Log::info('Total Orders: ' . $orders->count());
        
        $statusCounts = [];
        foreach ($orders as $order) {
            $status = trim($order->status); // Remove any extra spaces
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
            \Log::info('Order #' . $order->id . ' Status: "' . $order->status . '" (Length: ' . strlen($order->status) . ')');
        }
        
        \Log::info('Status Counts:', $statusCounts);
        \Log::info('=== END DEBUG ===');
    }

    public function loadDashboardData()
    {
        $this->loadStats();
        $this->loadRecentOrders();
        $this->loadTopProducts();
        $this->loadRecentCustomers();
        $this->loadOrderStatusCounts();
        $this->loadMonthlyRevenue();
        $this->loadCustomerGrowth();
        $this->loadSalesData();
    }

    public function loadStats()
    {
        // Get all orders with their statuses (trimmed)
        $allOrders = Order::all();
        
        // Count by status (with trimming)
        $statusCounts = [];
        foreach ($allOrders as $order) {
            $status = trim($order->status);
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
        }
        
        // Get completed/delivered orders for revenue calculation
        $completedOrders = Order::where('status', 'delivered');
        
        // Also check for any status that might contain 'delivered' (case insensitive)
        $deliveredOrders = Order::whereRaw('LOWER(TRIM(status)) = ?', ['delivered'])->get();
        
        \Log::info('Delivered orders count (exact): ' . $completedOrders->count());
        \Log::info('Delivered orders count (case-insensitive): ' . $deliveredOrders->count());

        // If there are delivered orders but the exact match didn't work, fix the data
        if ($deliveredOrders->count() > 0 && $completedOrders->count() === 0) {
            \Log::warning('Found delivered orders with different case/spacing. Fixing...');
            foreach ($deliveredOrders as $order) {
                $order->status = 'delivered';
                $order->save();
                \Log::info('Fixed order #' . $order->id . ' status to "delivered"');
            }
            // Reload completed orders after fix
            $completedOrders = Order::where('status', 'delivered');
        }

        $this->stats = [
            // Revenue - Only from delivered orders
            'total_revenue' => $completedOrders->sum('grand_total'),
            'today_revenue' => $completedOrders->whereDate('created_at', Carbon::today())->sum('grand_total'),
            'monthly_revenue' => $completedOrders->whereMonth('created_at', Carbon::now()->month)->sum('grand_total'),
            
            // Orders - All orders
            'total_orders' => $allOrders->count(),
            'today_orders' => $allOrders->where('created_at', '>=', Carbon::today())->count(),
            
            // Order Status Counts (All statuses)
            'pending_orders' => $statusCounts['pending'] ?? 0,
            'confirmed_orders' => $statusCounts['confirmed'] ?? 0,
            'processing_orders' => $statusCounts['processing'] ?? 0,
            'shipped_orders' => $statusCounts['shipped'] ?? 0,
            'delivered_orders' => $statusCounts['delivered'] ?? 0,
            'cancelled_orders' => $statusCounts['cancelled'] ?? 0,
            'returned_orders' => $statusCounts['returned'] ?? 0,
            
            // Other Stats
            'total_products' => Product::count(),
            'total_customers' => User::count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_reviews' => ProductReview::count(),
            'total_contact_messages' => ContactMessage::where('is_read', false)->count(),
            'total_offers' => Offer::active()->count(),
            'average_order_value' => $completedOrders->avg('grand_total') ?? 0,
        ];
    }

    public function loadRecentOrders()
    {
        $this->recentOrders = Order::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'invoice_no' => $order->invoice_no,
                    'customer_name' => $order->customer_name ?? $order->user?->name ?? 'Guest',
                    'customer_email' => $order->customer_email ?? $order->user?->email ?? 'N/A',
                    'grand_total' => $order->grand_total,
                    'status' => trim($order->status),
                    'status_badge' => $this->getStatusBadge(trim($order->status)),
                    'items_count' => $order->items->count(),
                    'created_at' => $order->created_at->diffForHumans(),
                    'payment_method' => $order->payment_method,
                ];
            })
            ->toArray();
    }

    public function loadTopProducts()
    {
        $this->topProducts = Product::select(
                'products.id',
                'products.name',
                'products.slug',
                'products.description',
                'products.brand_id',
                'products.status',
                'products.sku',
                'products.stock',
                'products.track',
                'products.meta_title',
                'products.meta_description',
                'products.meta_keywords',
                'products.scheduled_at',
                'products.deleted_at',
                'products.created_at',
                'products.updated_at',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            )
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->where(function($query) {
                $query->where('orders.status', 'delivered')
                      ->orWhereNull('orders.status');
            })
            ->groupBy(
                'products.id',
                'products.name',
                'products.slug',
                'products.description',
                'products.brand_id',
                'products.status',
                'products.sku',
                'products.stock',
                'products.track',
                'products.meta_title',
                'products.meta_description',
                'products.meta_keywords',
                'products.scheduled_at',
                'products.deleted_at',
                'products.created_at',
                'products.updated_at'
            )
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->media->first()?->file_path ?? asset('web/images/placeholder.jpg'),
                    'price' => $product->prices?->final_price ?? 0,
                    'total_sold' => $product->total_sold ?? 0,
                    'stock' => $product->stock,
                    'revenue' => ($product->prices?->final_price ?? 0) * ($product->total_sold ?? 0),
                ];
            })
            ->toArray();
    }

    public function loadRecentCustomers()
    {
        $this->recentCustomers = User::withCount('orders')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar ?? null,
                    'orders_count' => $user->orders_count,
                    'joined_at' => $user->created_at->diffForHumans(),
                    'total_spent' => $user->orders->where('status', 'delivered')->sum('grand_total') ?? 0,
                ];
            })
            ->toArray();
    }

    public function loadOrderStatusCounts()
    {
        // Get all orders and count by status (with trimming)
        $allOrders = Order::all();
        $statusCounts = [];
        
        foreach ($allOrders as $order) {
            $status = trim($order->status);
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
        }
        
        $this->orderStatusCounts = [
            'pending' => $statusCounts['pending'] ?? 0,
            'confirmed' => $statusCounts['confirmed'] ?? 0,
            'processing' => $statusCounts['processing'] ?? 0,
            'shipped' => $statusCounts['shipped'] ?? 0,
            'delivered' => $statusCounts['delivered'] ?? 0,
            'cancelled' => $statusCounts['cancelled'] ?? 0,
            'returned' => $statusCounts['returned'] ?? 0,
        ];
    }

    public function loadMonthlyRevenue()
    {
        $this->monthlyRevenue = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(grand_total) as total')
            )
            ->where('status', 'delivered')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M'),
                    'total' => $item->total,
                ];
            })
            ->toArray();
    }

    public function loadCustomerGrowth()
    {
        $this->customerGrowth = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    public function loadSalesData()
    {
        $this->salesData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total')
            )
            ->where('status', 'delivered')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'total' => $item->total,
                ];
            })
            ->toArray();
    }

    public function getStatusBadge($status)
    {
        $status = trim($status);
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipped' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'returned' => 'secondary',
        ];
        return $colors[$status] ?? 'secondary';
    }

    public function getPaymentBadge($method)
    {
        $colors = [
            'cod' => 'warning',
            'card' => 'primary',
            'bank' => 'info',
            'easy_paisa' => 'success',
        ];
        return $colors[$method] ?? 'secondary';
    }

    public function render()
    {
        return view('livewire.dashboard.index-component')
            ->extends('layouts.admin')
            ->section('admin-content');
    }
}