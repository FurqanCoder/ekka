<?php

namespace App\Livewire\Web\User;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // or tailwind based on your theme

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.web.user.order-list', [
            'orders' => $orders
        ])->extends('layouts.web')->section('web-content');
    }
}
