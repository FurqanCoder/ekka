<?php

namespace App\Livewire\Web;

use Livewire\Component;

class AboutUs extends Component
{
    public function render()
    {
        return view('livewire.web.about-us')->extends('layouts.web')->section('web-content');
    }
}
