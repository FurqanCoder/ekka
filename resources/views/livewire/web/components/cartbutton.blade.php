<div>
    {{-- <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle"> --}}
        <div class="header-icon "><i class="fi-rr-shopping-bag"></i></div>
        @if ($cartCount > 0)
            <span class="ec-header-count cart-count-lable ec-cart-noti">{{ $this->cartCount }}</span>
        @endif
    {{-- </a> --}}
</div>
