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
        $updates = ['status' => $this->status];
        $now = now();

        if ($this->status === 'confirmed') {
            $updates['confirmed_at'] = $now;
        } elseif ($this->status === 'shipped') {
            $updates['shipped_at'] = $now;
            $updates['confirmed_at'] = $this->order->confirmed_at ?? $now;
        } elseif ($this->status === 'delivered') {
            $updates['delivered_at'] = $now;
            $updates['shipped_at'] = $this->order->shipped_at ?? $now;
            $updates['confirmed_at'] = $this->order->confirmed_at ?? $now;

            if ($this->order->payment_method === 'cod') {
                $updates['payment_status'] = 'paid';
            }
        }

        $this->order->update($updates);
        $this->order->refresh();
        $this->status = $this->order->status;

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
