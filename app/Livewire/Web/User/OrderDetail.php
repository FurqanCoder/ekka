<?php

namespace App\Livewire\Web\User;

use App\Models\Order;
use Livewire\Component;

class OrderDetail extends Component
{
    public $order;

    public function mount($orderId)
    {
        $this->order = Order::with(['items', 'items.product.media'])
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);
    }

    public function render()
    {
        return view('livewire.web.user.order-detail')->extends('layouts.web')->section('web-content');
    }
}
