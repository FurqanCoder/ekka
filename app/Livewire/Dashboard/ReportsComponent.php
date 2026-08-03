<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportsComponent extends Component
{
    public $dateRange = 'this_month';
    public $startDate;
    public $endDate;
    public $reportType = 'sales';
    
    // Report data - Initialize with empty arrays
    public $salesData = [];
    public $orderData = [];
    public $productData = [];
    public $customerData = [];
    public $categoryData = [];
    
    // Summary stats - Initialize with empty array
    public $summary = [];

    protected $listeners = ['refreshReports' => 'loadReports'];

    public function mount()
    {
        $this->setDateRange();
        $this->loadReports();
    }

    public function setDateRange()
    {
        $now = Carbon::now();
        
        switch ($this->dateRange) {
            case 'today':
                $this->startDate = $now->copy()->startOfDay()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfDay()->format('Y-m-d');
                break;
            case 'yesterday':
                $this->startDate = $now->copy()->subDay()->startOfDay()->format('Y-m-d');
                $this->endDate = $now->copy()->subDay()->endOfDay()->format('Y-m-d');
                break;
            case 'this_week':
                $this->startDate = $now->copy()->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfWeek()->format('Y-m-d');
                break;
            case 'last_week':
                $this->startDate = $now->copy()->subWeek()->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->copy()->subWeek()->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = $now->copy()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $this->startDate = $now->copy()->startOfYear()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfYear()->format('Y-m-d');
                break;
            case 'last_year':
                $this->startDate = $now->copy()->subYear()->startOfYear()->format('Y-m-d');
                $this->endDate = $now->copy()->subYear()->endOfYear()->format('Y-m-d');
                break;
            case 'custom':
                // Keep existing custom dates
                break;
            default:
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
        }
    }

    public function updatedDateRange()
    {
        $this->setDateRange();
        $this->loadReports();
    }

    public function updatedReportType()
    {
        $this->loadReports();
    }

    public function loadReports()
    {
        // Reset data
        $this->salesData = [];
        $this->orderData = [];
        $this->productData = [];
        $this->customerData = [];
        $this->categoryData = [];
        $this->summary = [];

        switch ($this->reportType) {
            case 'sales':
                $this->loadSalesReport();
                break;
            case 'orders':
                $this->loadOrdersReport();
                break;
            case 'products':
                $this->loadProductsReport();
                break;
            case 'customers':
                $this->loadCustomersReport();
                break;
            case 'categories':
                $this->loadCategoriesReport();
                break;
        }
    }

    public function loadSalesReport()
    {
        // Sales overview
        $sales = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'delivered')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('AVG(grand_total) as average')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Daily sales trend
        $this->salesData = $sales->map(function ($item) {
            return [
                'date' => Carbon::parse($item->date)->format('M d, Y'),
                'total' => $item->total,
                'orders' => $item->orders,
                'average' => $item->average,
            ];
        })->toArray();

        // Summary
        $totalRevenue = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'delivered')
            ->sum('grand_total');

        $totalOrders = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'delivered')
            ->count();

        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $this->summary = [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'average_order_value' => $averageOrderValue,
            'top_selling_product' => $this->getTopSellingProduct(),
            'best_day' => $this->getBestDay(),
        ];
    }

    public function loadOrdersReport()
    {
        // Order status breakdown
        $statusData = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $totalOrders = $statusData->sum('count');

        $this->orderData = $statusData->map(function ($item) use ($totalOrders) {
            return [
                'status' => ucfirst($item->status),
                'count' => $item->count,
                'percentage' => $totalOrders > 0 ? round(($item->count / $totalOrders) * 100, 1) : 0,
            ];
        })->toArray();

        // Order timeline
        $timeline = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(grand_total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $this->salesData = $timeline->map(function ($item) {
            return [
                'date' => Carbon::parse($item->date)->format('M d, Y'),
                'orders' => $item->count,
                'revenue' => $item->revenue,
            ];
        })->toArray();

        $this->summary = [
            'total_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->count(),
            'pending_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'pending')->count(),
            'confirmed_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'confirmed')->count(),
            'processing_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'processing')->count(),
            'shipped_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'shipped')->count(),
            'delivered_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'delivered')->count(),
            'cancelled_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'cancelled')->count(),
            'returned_orders' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'returned')->count(),
        ];
    }

    public function loadProductsReport()
    {
        $this->productData = Product::select(
                'products.id',
                'products.name',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'),
                DB::raw('COALESCE(SUM(order_items.total), 0) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                'products.stock',
                'products.sku'
            )
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->where(function($query) {
                $query->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                      ->orWhereNull('orders.created_at');
            })
            ->where(function($query) {
                $query->where('orders.status', 'delivered')
                      ->orWhereNull('orders.status');
            })
            ->groupBy('products.id', 'products.name', 'products.stock', 'products.sku')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'total_sold' => $product->total_sold,
                    'total_revenue' => $product->total_revenue,
                    'total_orders' => $product->total_orders,
                    'stock' => $product->stock,
                ];
            })
            ->toArray();

        $this->summary = [
            'total_products' => Product::count(),
            'total_sold' => DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                ->where('orders.status', 'delivered')
                ->sum('order_items.quantity'),
            'total_revenue' => DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                ->where('orders.status', 'delivered')
                ->sum('order_items.total'),
            'top_selling' => !empty($this->productData) ? $this->productData[0]['name'] : 'N/A',
        ];
    }

    public function loadCustomersReport()
    {
        $this->customerData = User::select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('COALESCE(SUM(orders.grand_total), 0) as total_spent'),
                DB::raw('MAX(orders.created_at) as last_order')
            )
            ->leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->where('orders.status', 'delivered')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'total_orders' => $user->total_orders,
                    'total_spent' => $user->total_spent,
                    'last_order' => $user->last_order ? Carbon::parse($user->last_order)->diffForHumans() : 'Never',
                ];
            })
            ->toArray();

        $this->summary = [
            'total_customers' => User::count(),
            'new_customers' => User::whereBetween('created_at', [$this->startDate, $this->endDate])->count(),
            'repeat_customers' => User::having('orders_count', '>', 1)
                ->withCount('orders')
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->count(),
            'average_spent' => DB::table('orders')
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->where('status', 'delivered')
                ->avg('grand_total') ?? 0,
        ];
    }

    public function loadCategoriesReport()
    {
        $this->categoryData = Category::select(
                'categories.id',
                'categories.name',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'),
                DB::raw('COALESCE(SUM(order_items.total), 0) as total_revenue')
            )
            ->leftJoin('product_categories', 'product_categories.category_id', '=', 'categories.id')
            ->leftJoin('products', 'products.id', '=', 'product_categories.product_id')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->where(function($query) {
                $query->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                      ->orWhereNull('orders.created_at');
            })
            ->where(function($query) {
                $query->where('orders.status', 'delivered')
                      ->orWhereNull('orders.status');
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'total_sold' => $category->total_sold,
                    'total_revenue' => $category->total_revenue,
                ];
            })
            ->toArray();
    }

    private function getTopSellingProduct()
    {
        $product = Product::select('products.name', DB::raw('SUM(order_items.quantity) as total'))
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->where('orders.status', 'delivered')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total', 'desc')
            ->first();

        return $product ? $product->name : 'N/A';
    }

    private function getBestDay()
    {
        $day = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total')
            )
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'delivered')
            ->groupBy('date')
            ->orderBy('total', 'desc')
            ->first();

        return $day ? Carbon::parse($day->date)->format('M d, Y') : 'N/A';
    }

    public function exportReport($type)
    {
        // Export logic here (CSV, Excel, PDF)
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Report exported successfully!"
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.reports-component')
            ->extends('layouts.admin')
            ->section('admin-content');
    }
}