<?php

namespace App\Livewire\Dashboard\Settings;

use Livewire\Component;

class OfferCardComponent extends Component
{
    public function render()
    {
        return view('livewire.dashboard.settings.offer-card-component')->extends('layouts.admin')
            ->section('admin-content');
    }
}
