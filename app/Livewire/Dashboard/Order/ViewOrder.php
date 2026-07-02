<?php

namespace App\Livewire\Dashboard\Order;

use App\Models\Order;
use Livewire\Component;

class ViewOrder extends Component
{
     public Order $order;

    public $status;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->status = $order->status;
    }

    public function updateStatus()
    {
        $this->order->update([
            'status' => $this->status
        ]);

        session()->flash('success', 'Order status updated.');
    }

    public function render()
    {
        return view('livewire.dashboard.order.view-order', [
            'items' => $this->order->items
        ])->extends('layouts.admin')->section('admin-content');
    }
    // public function render()
    // {
    //     return view('livewire.dashboard.order.view-order')->extends('layouts.admin')->section('admin-content');
    // }
}
