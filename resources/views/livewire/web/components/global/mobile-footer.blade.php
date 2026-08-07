<div>
    <!-- Footer navigation panel for responsive display -->
    <div class="ec-nav-toolbar">
        <div class="container">
            <div class="ec-nav-panel">
                <div class="ec-nav-panel-icons">
                    <a href="#ec-mobile-menu" class="navbar-toggler-btn ec-header-btn ec-side-toggle"><i
                            class="fi-rr-menu-burger"></i></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="#ec-side-cart" class="toggle-cart ec-header-btn ec-side-toggle">@livewire('web.components.cartbutton')</a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="{{ route('home') }}" class="ec-header-btn"><i class="fi-rr-home"></i></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="{{ route('web.wish') }}" class="ec-header-btn">@livewire('web.components.wish.wish-icon')</a>
                </div>
                <div class="ec-nav-panel-icons">
                    @guest
                        {{-- TODO: replace with real login/register routes once auth is built --}}
                        <a href="" class="ec-header-btn" wire:click="showLogin">><i class="fi-rr-user"></i></a>

                    @endguest

                    @auth
                        <a href="{{ route('web.user.order') }}" class="ec-header-btn"><i class="fi-rr-user"></i></a>
                    @endauth
                </div>

            </div>
        </div>
    </div>
    <!-- Footer navigation panel for responsive display end -->
</div>
