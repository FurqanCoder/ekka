<?php

namespace App\Livewire\Web\Dashboard;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class UserOrders extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $search = '';
    public $perPage = 10;

    protected $queryString = ['statusFilter', 'search'];

    public function render()
    {
        $orders = Order::with(['items'])
            ->where('user_id', Auth::id())
            ->when($this->statusFilter !== 'all', function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                return $query->where('invoice_no', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $statuses = ['all', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        return view('livewire.web.dashboard.user-orders', [
            'orders' => $orders,
            'statuses' => $statuses,
        ]);
    }

    public function getStatusBadge($status)
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

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing'])
            ->first();

        if ($order) {
            $order->update(['status' => 'cancelled']);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Order cancelled successfully!']);
            $this->resetPage();
        } else {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Cannot cancel this order.']);
        }
    }
}