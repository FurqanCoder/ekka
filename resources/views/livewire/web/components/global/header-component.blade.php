<div>
    @php
        $settings = \App\Helpers\WebsiteHelper::getSettings();
    @endphp
    <header class="ec-header">

        <!-- Header Top Start -->
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Social icons -->
                    <div class="col text-left header-top-left d-none d-lg-block">
                        <div class="header-top-social">
                            <span class="social-text text-upper">Follow us on:</span>
                            <ul class="mb-0">
                                @foreach (\App\Helpers\WebsiteHelper::getSocialLinks() as $platform => $url)
                                    <li class="list-inline-item"><a class="hdr-{{ $platform }}"
                                            href="{{ $url }}" target="_blank"><i
                                                class="ecicon eci-{{ $platform }}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Promo message -->
                    <div class="col text-center header-top-center">
                        <div class="header-top-message text-upper">
                            {{ $settings->website_tagline }}
                        </div>
                    </div>

                    <!-- Mobile-only quick actions -->
                    <div class="col d-lg-none">
                        <div class="ec-header-bottons">
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                        class="fi-rr-user"></i></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    {{-- TODO: wire up once auth routes exist --}}
                                    <li><button wire:click="showSignup" class="dropdown-item"
                                            href="#">Register</button></li>
                                    <li><a class="dropdown-item" href="#">Login</a></li>
                                </ul>
                            </div>

                            @livewire('web.components.wish.wish-icon')
                            @livewire('web.components.cartbutton')

                            <a href="javascript:void(0)" class="ec-header-btn ec-sidebar-toggle">
                                <i class="fi fi-rr-apps"></i>
                            </a>
                            <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                                <i class="fi fi-rr-menu-burger"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Top End -->

        <!-- Header Bottom (Desktop) Start -->
        <div class="ec-header-bottom d-none d-lg-block">
            <div class="container position-relative">
                <div class="row">
                    <div class="ec-flex">

                        <!-- Logo -->
                        <div class="align-self-center">
                            <div class="header-logo">
                                <a href="{{ route('home') }}" class="navbar-brand">
                                    @if ($settings->logo_light_url)
                                        <img src="{{ $settings->logo_light_url }}"
                                            alt="{{ $settings->logo_alt_text ?? 'Site Logo' }}" class="logo-light"
                                            height="40">
                                    @else
                                        <img src="{{ asset('web/images/logo/logo.png') }}" alt="Site Logo"
                                            class="logo-light" height="40">
                                    @endif

                                    @if ($settings->logo_dark_url)
                                        <img src="{{ $settings->logo_dark_url }}"
                                            alt="{{ $settings->logo_alt_text ?? 'Site Logo' }}" class="logo-dark"
                                            style="display: none;" height="40">
                                    @else
                                        <img class="dark-logo" src="{{ asset('web/images/logo/dark-logo.png') }}"
                                            alt="Site Logo" style="display: none;" height="40">
                                    @endif
                                </a>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="align-self-center">
                            <div class="header-search">
                                <form class="ec-btn-group-form" action="{{ route('web.filter') }}" method="GET">
                                    <input class="form-control ec-search-bar" name="search"
                                        placeholder="Search products..." type="text"
                                        value="{{ request('search') }}">
                                    <button class="submit" type="submit">
                                        <i class="fi-rr-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- User / Wishlist / Cart -->
                        <div class="align-self-center">
                            <div class="ec-header-bottons">
                                <div class="ec-header-user dropdown">
                                    <button class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                            class="fi-rr-user"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @guest
                                            {{-- TODO: replace with real login/register routes once auth is built --}}
                                            <li><button class="dropdown-item" wire:click="showLogin">Login</button></li>
                                            <li><a class="dropdown-item" wire:click="showSignup">Register</a></li>
                                        @endguest

                                        @auth
                                            <li><a class="dropdown-item" href="{{ route('web.user.order') }}">My Orders</a>
                                            </li>
                                        @endauth
                                    </ul>
                                </div>

                                <button class="ec-header-btn" data-theme-toggle aria-label="Toggle dark mode"><i
                                            class="fi-rr-moon"></i></button>
                                <a href="{{ route('web.wish') }}" class="ec-header-btn ec-header-wishlist">
                                    @livewire('web.components.wish.wish-icon')
                                </a>
                                <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                    @livewire('web.components.cartbutton')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Bottom (Desktop) End -->

        <!-- Header Bottom (Mobile) Start -->
        <div class="ec-header-bottom d-lg-none">
            <div class="container position-relative">
                <div class="row">
                    <div class="col">
                        <div class="header-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('web/images/logo/logo.png') }}" alt="Site Logo">
                                <img class="dark-logo" src="{{ asset('web/images/logo/dark-logo.png') }}"
                                    alt="Site Logo" style="display: none;">
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="header-search">
                            <form class="ec-btn-group-form" action="{{ route('web.filter') }}" method="GET">
                                <input class="form-control ec-search-bar" name="search"
                                    placeholder="Search products..." type="text">
                                <button class="submit" type="submit"><i class="fi-rr-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Bottom (Mobile) End -->

        <!-- Main Menu (Desktop) Start -->
        <div id="ec-main-menu-desk" class="d-none d-lg-block sticky-nav">
            <div class="container position-relative">
                <div class="row">
                    <div class="col-md-12 align-self-center">
                        <div class="ec-main-menu">
                            <a href="javascript:void(0)" class="ec-header-btn ec-sidebar-toggle">
                                <i class="fi fi-rr-apps"></i>
                            </a>
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>

                                <!-- Categories: dynamic, pass $categories from a view composer or controller -->
                                <li class="dropdown position-static">
                                    <a href="javascript:void(0)">Categories</a>
                                    <ul class="mega-menu d-block">
                                        @isset($categories)
                                            @foreach ($categories as $category)
                                                <li class="menu_title">
                                                    <a
                                                        href="{{ route('web.filter', ['category' => $category['slug']]) }}">
                                                        {{ $category['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="menu_title"><a href="javascript:void(0)">No categories yet</a></li>
                                        @endisset
                                    </ul>
                                </li>

                                <li><a href="{{ route('web.filter') }}">Shop</a></li>

                                @auth
                                    <li><a href="{{ route('web.user.order') }}">My Orders</a></li>
                                @endauth
                                <li><a href="{{ route('web.contact-us') }}">Contact Us</a></li>
                                <li><a href="{{ route('web.about-us') }}">About Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Menu (Desktop) End -->

        <!-- Mobile Menu Start -->
        <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
            <div class="ec-menu-title">
                <span class="menu_title">My Menu</span>
                <button class="ec-close">×</button>
            </div>
            <div class="ec-menu-inner">
                <div class="ec-menu-content">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('web.filter') }}">Shop</a></li>
                        <li><a href="{{ route('web.wish') }}">Wishlist</a></li>
                        <li><a href="{{ route('web-cart') }}">Cart</a></li>
                        <li><a href="{{ route('web-check-out') }}">Checkout</a></li>

                        @auth
                            <li><a href="{{ route('web.user.order') }}">My Orders</a></li>
                        @else
                            {{-- TODO: swap in real login/register routes --}}
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Register</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Social -->
                <div class="header-res-social">
                    <div class="header-top-social">
                        <ul class="mb-0">
                            @foreach (\App\Helpers\WebsiteHelper::getSocialLinks() as $platform => $url)
                            <li class="list-inline-item"><a class="hdr-{{ $platform }}" href="{{$url}}"><i
                                        class="ecicon eci-{{ $platform }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu End -->

    </header>
</div>
