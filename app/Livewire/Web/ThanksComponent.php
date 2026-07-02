<?php

namespace App\Livewire\Web;

use App\Models\Order;
use Livewire\Component;

class ThanksComponent extends Component
{
    public $order;
   public function mount()
{
    $user = auth()->user();

    $this->order = Order::where('user_id', $user->id)
                        ->latest()
                        ->first();
}

    public function render()
    {
        return view('livewire.web.thanks-component')->extends('layouts.web')->section('web-content');;
    }
}
