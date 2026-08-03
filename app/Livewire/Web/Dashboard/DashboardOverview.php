<?php

namespace App\Livewire\Web\Dashboard;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardOverview extends Component
{
    public $recentOrders = [];
    public $stats = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $userId = Auth::id();
        
        $this->stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'pending_orders' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'total_spent' => Order::where('user_id', $userId)->sum('grand_total'),
            'wishlist_count' => \App\Models\Wishlist::where('user_id', $userId)->count(),
        ];

        $this->recentOrders = Order::with(['items'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'invoice_no' => $order->invoice_no,
                    'grand_total' => $order->grand_total,
                    'status' => $order->status,
                    'status_badge' => $this->getStatusBadge($order->status),
                    'created_at' => $order->created_at->diffForHumans(),
                    'items_count' => $order->items->count(),
                ];
            });
    }

    private function getStatusBadge($status)
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];
        return $colors[$status] ?? 'secondary';
    }

    public function render()
    {
        return view('livewire.web.dashboard.dashboard-overview');
    }
}