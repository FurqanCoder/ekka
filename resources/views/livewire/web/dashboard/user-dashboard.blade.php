<!-- resources/views/livewire/web/dashboard/user-dashboard.blade.php -->
<div>
    <div class="container py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="dashboard-sidebar card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <!-- User Profile -->
                        <div class="text-center mb-4 pb-3 border-bottom">
                            <div class="avatar-circle mx-auto mb-3">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <span class="avatar-initials">{{ auth()->user()->initials() }}</span>
                                @endif
                            </div>
                            <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>

                        <!-- Navigation -->
                        <nav class="dashboard-nav">
                            <a href="#" wire:click.prevent="setActiveTab('overview')" 
                               class="nav-link {{ $activeTab == 'overview' ? 'active' : '' }}">
                                <i class="fa-solid fa-gauge-high me-2"></i> Overview
                            </a>
                            <a href="#" wire:click.prevent="setActiveTab('orders')" 
                               class="nav-link {{ $activeTab == 'orders' ? 'active' : '' }}">
                                <i class="fa-solid fa-box me-2"></i> Orders
                                <span class="badge bg-primary float-end">{{ $stats['total_orders'] ?? 0 }}</span>
                            </a>
                            <a href="#" wire:click.prevent="setActiveTab('addresses')" 
                               class="nav-link {{ $activeTab == 'addresses' ? 'active' : '' }}">
                                <i class="fa-solid fa-location-dot me-2"></i> Addresses
                                <span class="badge bg-secondary float-end">{{ $stats['total_addresses'] ?? 0 }}</span>
                            </a>
                            <a href="{{route('web.wish')}}" 
                               class="nav-link {{ $activeTab == 'wishlist' ? 'active' : '' }}">
                                <i class="fa-solid fa-heart me-2"></i> Wishlist
                                <span class="badge bg-danger float-end">{{ $stats['wishlist_count'] ?? 0 }}</span>
                            </a>
                            <a href="#" wire:click.prevent="setActiveTab('profile')" 
                               class="nav-link {{ $activeTab == 'profile' ? 'active' : '' }}">
                                <i class="fa-solid fa-user me-2"></i> Profile Settings
                            </a>
                            <hr>
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="nav-link text-danger">
                                <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9 col-md-8">
                <div class="dashboard-content card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        @switch($activeTab)
                            @case('overview')
                                @livewire('web.dashboard.dashboard-overview')
                            @break

                            @case('orders')
                                @livewire('web.dashboard.user-orders')
                            @break

                            @case('addresses')
                                @livewire('web.dashboard.user-addresses')
                            @break

                            @case('wishlist')
                                @livewire('web.dashboard.user-wishlist')
                            @break

                            @case('profile')
                                @livewire('web.dashboard.user-profile')
                            @break

                            @default
                                @livewire('web.dashboard.dashboard-overview')
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-sidebar {
            position: sticky;
            top: 20px;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
        }

        .avatar-initials {
            font-size: 28px;
            font-weight: 600;
        }

        .dashboard-nav .nav-link {
            padding: 10px 15px;
            border-radius: 8px;
            color: #64748b;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .dashboard-nav .nav-link:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .dashboard-nav .nav-link.active {
            background: #1e40af;
            color: white;
        }

        .dashboard-nav .nav-link .badge {
            font-size: 11px;
            padding: 3px 8px;
        }

        .dashboard-content {
            min-height: 500px;
        }

        @media (max-width: 768px) {
            .dashboard-sidebar {
                position: relative;
                top: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</div>