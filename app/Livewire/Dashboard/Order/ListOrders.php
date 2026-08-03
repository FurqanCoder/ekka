<?php

namespace App\Livewire\Dashboard\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class ListOrders extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $paymentStatus = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'paymentStatus' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedPaymentStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Order::query()
            ->when($this->search, function ($q) {
                $q->where('invoice_no', 'like', "%{$this->search}%")
                    ->orWhere('customer_phone', 'like', "%{$this->search}%")
                    ->orWhere('customer_name', 'like', "%{$this->search}%");
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->paymentStatus, fn($q) => $q->where('payment_status', $this->paymentStatus));

        $orders = (clone $query)->latest()->paginate(15);

        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'processing' => (clone $query)->where('status', 'processing')->count(),
            'shipped' => (clone $query)->where('status', 'shipped')->count(),
            'delivered' => (clone $query)->where('status', 'delivered')->count(),
            'revenue' => (clone $query)->sum('grand_total'),
        ];

        return view('livewire.dashboard.order.list-orders', [
            'orders' => $orders,
            'stats' => $stats,
        ])->extends('layouts.admin')->section('admin-content');
    }
}
