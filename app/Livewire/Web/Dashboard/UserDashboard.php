<?php

namespace App\Livewire\Web\Dashboard;

use Livewire\Component;
use App\Models\Order;
use App\Models\Address;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public $activeTab = 'overview';
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = Auth::id();
        
        $this->stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'pending_orders' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'processing_orders' => Order::where('user_id', $userId)->where('status', 'processing')->count(),
            'completed_orders' => Order::where('user_id', $userId)->where('status', 'delivered')->count(),
            'total_addresses' => Address::where('user_id', $userId)->count(),
            'wishlist_count' => Wishlist::where('user_id', $userId)->count(),
        ];
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.web.dashboard.user-dashboard')
            ->extends('layouts.web')
            ->section('web-content');
    }
}