<?php

namespace App\Livewire\Dashboard\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

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

    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }
    public function updatedPaymentStatus() { $this->resetPage(); }

    public function render()
    {
        $orders = Order::query()
            ->when($this->search, function ($q) {
                $q->where('invoice_no', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->paymentStatus, fn($q) => $q->where('payment_status', $this->paymentStatus))
            ->latest()
            ->paginate(15);

        return view('livewire.dashboard.order.list-orders', [
            'orders' => $orders
        ])->extends('layouts.admin')->section('admin-content');
    }
    // public function render()
    // {
    //     return view('livewire.dashboard.order.list-orders')->extends('layouts.admin')->section('admin-content');;
    // }
}
