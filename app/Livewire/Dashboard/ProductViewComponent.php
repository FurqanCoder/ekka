<?php

namespace App\Livewire\Dashboard;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ProductViewComponent extends Component
{
    use WithPagination;

    public $productId;
    public $product;
    public $activeTab = 'overview';
    
    // Review properties
    public $reviewId;
    public $reviewReply;
    public $showReplyModal = false;
    
    // Filters
    public $reviewFilter = 'all';
    public $searchReview = '';
    
    protected $listeners = ['refreshProduct' => 'loadProduct'];

    public function mount($id)
    {
        $this->productId = $id;
        $this->loadProduct();
    }

    public function loadProduct()
    {
        $this->product = Product::with([
            'brand',
            'categories',
            'media',
            'prices',
            'variants',
            'reviews.user',
            'reviews' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($this->productId);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    // ============================================
    // REVIEW MANAGEMENT
    // ============================================

    public function getReviews()
    {
        $query = ProductReview::with('user')
            ->where('product_id', $this->productId)
            ->when($this->reviewFilter === 'approved', function($q) {
                return $q->where('approved', true);
            })
            ->when($this->reviewFilter === 'pending', function($q) {
                return $q->where('approved', false);
            })
            ->when($this->searchReview, function($q) {
                return $q->where(function($query) {
                    $query->where('review', 'like', '%' . $this->searchReview . '%')
                        ->orWhereHas('user', function($sub) {
                            $sub->where('name', 'like', '%' . $this->searchReview . '%');
                        });
                });
            })
            ->orderBy('created_at', 'desc');

        return $query->paginate(10);
    }

    public function approveReview($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->update([
            'approved' => true,
            'approved_at' => now(),
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Review approved successfully!'
        ]);
    }

    public function rejectReview($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->update([
            'approved' => false,
            'approved_at' => null,
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Review rejected successfully!'
        ]);
    }

    public function deleteReview($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Review deleted successfully!'
        ]);
    }

    public function showReplyForm($id)
    {
        $this->reviewId = $id;
        $this->reviewReply = '';
        $this->showReplyModal = true;
        $this->dispatch('show-reply-modal');
    }

    public function saveReply()
    {
        $this->validate([
            'reviewReply' => 'required|string|min:3|max:1000',
        ]);

        $review = ProductReview::findOrFail($this->reviewId);
        $review->update([
            'reply' => $this->reviewReply,
            'replied_at' => now(),
            'replied_by' => auth()->id(),
        ]);

        $this->showReplyModal = false;
        $this->reviewReply = '';
        $this->reviewId = null;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Reply added successfully!'
        ]);
    }

    // ============================================
    // STATISTICS
    // ============================================

    public function getStats()
    {
        $totalOrders = OrderItem::where('product_id', $this->productId)
            ->whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })
            ->sum('quantity');

        $totalRevenue = OrderItem::where('product_id', $this->productId)
            ->whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })
            ->sum('total');

        $totalReviews = ProductReview::where('product_id', $this->productId)->count();
        $approvedReviews = ProductReview::where('product_id', $this->productId)->where('approved', true)->count();
        $pendingReviews = ProductReview::where('product_id', $this->productId)->where('approved', false)->count();
        $averageRating = ProductReview::where('product_id', $this->productId)->where('approved', true)->avg('rating') ?? 0;

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_reviews' => $totalReviews,
            'approved_reviews' => $approvedReviews,
            'pending_reviews' => $pendingReviews,
            'average_rating' => round($averageRating, 1),
            'rating_distribution' => $this->getRatingDistribution(),
        ];
    }

    public function getRatingDistribution()
    {
        $distribution = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        $ratings = ProductReview::where('product_id', $this->productId)
            ->where('approved', true)
            ->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->get();

        foreach ($ratings as $rating) {
            $distribution[$rating->rating] = $rating->count;
        }

        return $distribution;
    }

    // ============================================
    // SALES DATA
    // ============================================

    public function getSalesData()
    {
        $sales = OrderItem::where('product_id', $this->productId)
            ->whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return $sales->map(function($item) {
            return [
                'date' => $item->date,
                'quantity' => $item->quantity,
                'revenue' => $item->revenue,
            ];
        })->toArray();
    }

    public function getTopCustomers()
    {
        return OrderItem::where('product_id', $this->productId)
            ->whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })
            ->with('order.user')
            ->select(
                'order_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total) as total_spent')
            )
            ->groupBy('order_id')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return [
                    'customer_name' => $item->order->user->name ?? $item->order->customer_name ?? 'Guest',
                    'customer_email' => $item->order->user->email ?? $item->order->customer_email ?? 'N/A',
                    'total_quantity' => $item->total_quantity,
                    'total_spent' => $item->total_spent,
                ];
            })
            ->toArray();
    }

    // ============================================
    // EXPORT
    // ============================================

    public function exportReviews()
    {
        $reviews = ProductReview::where('product_id', $this->productId)
            ->with('user')
            ->get();

        // Create CSV
        $filename = 'product-reviews-' . $this->product->slug . '.csv';
        $handle = fopen('php://output', 'w');
        
        fputcsv($handle, ['Reviewer', 'Rating', 'Review', 'Status', 'Date']);
        
        foreach ($reviews as $review) {
            fputcsv($handle, [
                $review->user->name ?? 'Anonymous',
                $review->rating . ' stars',
                $review->review,
                $review->approved ? 'Approved' : 'Pending',
                $review->created_at->format('M d, Y'),
            ]);
        }
        
        fclose($handle);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Reviews exported successfully!'
        ]);
    }

    public function render()
    {
        $stats = $this->getStats();
        $reviews = $this->getReviews();
        $salesData = $this->getSalesData();
        $topCustomers = $this->getTopCustomers();
        $ratingDistribution = $this->getRatingDistribution();

        return view('livewire.dashboard.product-view-component', [
            'product' => $this->product,
            'stats' => $stats,
            'reviews' => $reviews,
            'salesData' => $salesData,
            'topCustomers' => $topCustomers,
            'ratingDistribution' => $ratingDistribution,
        ])->extends('layouts.admin')->section('admin-content');
    }
}