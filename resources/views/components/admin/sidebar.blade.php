<aside class="side-mini-panel with-vertical">
    @php
        $activeSection = match(true) {
            request()->routeIs('admin.dashboard') => 1,
            request()->routeIs('dev.product', 'dev-add-product', 'dev-edit-product', 'dev-category', 'dev-content') => 2,
            request()->routeIs('dev-order.*', 'dev-shipping', 'admin.orders.*') => 3,
            // Customers has no routes yet, so nothing will match section 4 until you add some
            request()->routeIs('dev-coupons', 'dev-discounts') => 5,
            // Reports has no routes yet
            request()->routeIs('settings.*') => 7,
            default => 1,
        };
    @endphp
    <div class="iconbar">
        <div>
            <div class="mini-nav">
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                </div>
                <ul class="mini-nav-ul" data-simplebar="">
                    <li class="mini-nav-item {{ $activeSection === 1 ? 'active' : '' }}" id="mini-1">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Dashboards">
                            <iconify-icon icon="solar:layers-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item {{ $activeSection === 2 ? 'active' : '' }}" id="mini-2">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Catalog">
                            <iconify-icon icon="solar:box-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item {{ $activeSection === 3 ? 'active' : '' }}" id="mini-3">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Sales">
                            <iconify-icon icon="solar:cart-large-4-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item {{ $activeSection === 4 ? 'active' : '' }}" id="mini-4">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Customers">
                            <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item {{ $activeSection === 5 ? 'active' : '' }}" id="mini-5">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Marketing">
                            <iconify-icon icon="solar:tag-price-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item {{ $activeSection === 6 ? 'active' : '' }}" id="mini-6">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Reports">
                            <iconify-icon icon="solar:chart-2-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item {{ $activeSection === 7 ? 'active' : '' }}" id="mini-7">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Settings">
                            <iconify-icon icon="solar:settings-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebarmenu">
                <div class="brand-logo d-flex align-items-center nav-logo">
                    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="Logo" />
                    </a>
                </div>

                {{-- Dashboards panel --}}
                <nav class="sidebar-nav {{ $activeSection === 1 ? 'active' : '' }}" id="menu-right-mini-1" data-simplebar="">
                    <ul class="sidebar-menu" id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Dashboards</span>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin/deshboard') }}" id="get-url" aria-expanded="false">
                                <iconify-icon icon="solar:widget-4-line-duotone"></iconify-icon>
                                <span class="hide-menu">Overview</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:graph-new-line-duotone"></iconify-icon>
                                <span class="hide-menu">Sales Analytics</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                {{-- Catalog panel --}}
                <nav class="sidebar-nav {{ $activeSection === 2 ? 'active' : '' }}" id="menu-right-mini-2" data-simplebar="">
                    <ul class="sidebar-menu" id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Catalog</span>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev.product') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev.product') ? '' : 'disabled' }}" href="{{ Route::has('dev.product') ? route('dev.product') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:box-minimalistic-line-duotone"></iconify-icon>
                                <span class="hide-menu">All Products</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev-add-product') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev-add-product') ? '' : 'disabled' }}" href="{{ Route::has('dev-add-product') ? route('dev-add-product') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:add-square-line-duotone"></iconify-icon>
                                <span class="hide-menu">Add Product</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev-category') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev-category') ? '' : 'disabled' }}" href="{{ Route::has('dev-category') ? route('dev-category') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:folder-with-files-line-duotone"></iconify-icon>
                                <span class="hide-menu">Categories</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev-content') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev-content') ? '' : 'disabled' }}" href="{{ Route::has('dev-content') ? route('dev-content') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:tag-line-duotone"></iconify-icon>
                                <span class="hide-menu">Brands</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:pallet-line-duotone"></iconify-icon>
                                <span class="hide-menu">Inventory &amp; Stock</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:star-line-duotone"></iconify-icon>
                                <span class="hide-menu">Reviews</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                {{-- Sales panel --}}
                <nav class="sidebar-nav {{ $activeSection === 3 ? 'active' : '' }}" id="menu-right-mini-3" data-simplebar="">
                    <ul class="sidebar-menu" id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Sales</span>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev-order.lists') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev-order.lists') ? '' : 'disabled' }}" href="{{ Route::has('dev-order.lists') ? route('dev-order.lists') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:bag-check-line-duotone"></iconify-icon>
                                <span class="hide-menu">Orders</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:undo-left-line-duotone"></iconify-icon>
                                <span class="hide-menu">Returns &amp; Refunds</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:bill-list-line-duotone"></iconify-icon>
                                <span class="hide-menu">Invoices</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:card-line-duotone"></iconify-icon>
                                <span class="hide-menu">Payments</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev-shipping') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev-shipping') ? '' : 'disabled' }}" href="{{ Route::has('dev-shipping') ? route('dev-shipping') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:delivery-line-duotone"></iconify-icon>
                                <span class="hide-menu">Shipping &amp; Tracking</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                {{-- Customers panel --}}
                <nav class="sidebar-nav {{ $activeSection === 4 ? 'active' : '' }}" id="menu-right-mini-4" data-simplebar="">
                    <ul class="sidebar-menu" id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Customers</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:users-group-two-rounded-line-duotone"></iconify-icon>
                                <span class="hide-menu">All Customers</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:chat-round-line-line-duotone"></iconify-icon>
                                <span class="hide-menu">Support Tickets</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:heart-line-duotone"></iconify-icon>
                                <span class="hide-menu">Wishlists</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                {{-- Marketing panel --}}
                <nav class="sidebar-nav {{ $activeSection === 5 ? 'active' : '' }}" id="menu-right-mini-5" data-simplebar="">
                    <ul class="sidebar-menu" id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Marketing</span>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev-coupons') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev-coupons') ? '' : 'disabled' }}" href="{{ Route::has('dev-coupons') ? route('dev-coupons') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:ticket-line-duotone"></iconify-icon>
                                <span class="hide-menu">Coupons</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('dev-discounts') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('dev-discounts') ? '' : 'disabled' }}" href="{{ Route::has('dev-discounts') ? route('dev-discounts') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:discount-circle-line-duotone"></iconify-icon>
                                <span class="hide-menu">Offers &amp; Discounts</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:mailbox-line-duotone"></iconify-icon>
                                <span class="hide-menu">Email Campaigns</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:cart-cross-line-duotone"></iconify-icon>
                                <span class="hide-menu">Abandoned Carts</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                {{-- Reports panel --}}
                <nav class="sidebar-nav {{ $activeSection === 6 ? 'active' : '' }}" id="menu-right-mini-6" data-simplebar="">
                    <ul class="sidebar-menu" id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Reports</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:chart-square-line-duotone"></iconify-icon>
                                <span class="hide-menu">Sales Reports</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:trending-up-line-duotone"></iconify-icon>
                                <span class="hide-menu">Traffic &amp; Conversion</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:medal-ribbons-star-line-duotone"></iconify-icon>
                                <span class="hide-menu">Top Products</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                {{-- Settings panel --}}
                <nav class="sidebar-nav {{ $activeSection === 7 ? 'active' : '' }}" id="menu-right-mini-7" data-simplebar="">
                    <ul class="sidebar-menu" id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Settings</span>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('settings.profile') ? '' : 'disabled' }}" href="{{ Route::has('settings.profile') ? route('settings.profile') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:user-circle-line-duotone"></iconify-icon>
                                <span class="hide-menu">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('settings.password') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('settings.password') ? '' : 'disabled' }}" href="{{ Route::has('settings.password') ? route('settings.password') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:lock-password-line-duotone"></iconify-icon>
                                <span class="hide-menu">Password</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('settings.appearance') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Route::has('settings.appearance') ? '' : 'disabled' }}" href="{{ Route::has('settings.appearance') ? route('settings.appearance') : '#' }}" aria-expanded="false">
                                <iconify-icon icon="solar:pallete-2-line-duotone"></iconify-icon>
                                <span class="hide-menu">Appearance</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:shop-line-duotone"></iconify-icon>
                                <span class="hide-menu">Store Settings</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:wallet-money-line-duotone"></iconify-icon>
                                <span class="hide-menu">Payment Methods</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link disabled" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:shield-user-line-duotone"></iconify-icon>
                                <span class="hide-menu">Staff &amp; Roles</span>
                                <span class="badge bg-secondary rounded-pill ms-auto">Soon</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</aside>