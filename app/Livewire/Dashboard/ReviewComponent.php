<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class ReviewComponent extends Component
{
    public function render()
    {
        return view('livewire.dashboard.review-component')->extends('layouts.admin')->section('admin-content');;
    }
}
