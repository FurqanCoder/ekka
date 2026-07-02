<div class="ec-checkout-summary" style="width: 100%;display:flex;flex-direction:column" >
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="d-flex w-100 " style="align-items: space-between">
        <span class="text-left">Coupan Discount</span>
        <span class="text-right" style="float: right" ><a class="ec-checkout-coupan">Apply Coupan</a></span>
    </div>
    @if (!$applied)
    <div class="ec-checkout-coupan-content w-100">
        <p class="ec-checkout-coupan-form">
            <input class="ec-coupan" type="text" required=""
                placeholder="Enter Your Coupan Code" wire:model="code" value="">
            <button class="button btn-primary" wire:click="applyCoupon"
                value="">Apply</button>
        </p>
    </div>
      @else
      <div class="flex items-center justify-between">
            <span class="font-medium text-green-600" style="color: #198754;font:bolder">
                Coupon <strong>{{ $applied['code'] }}</strong> applied!
                <span class="text-sm text-gray-500">(Discount: {{ '₨ ' . number_format($applied['discount'], 2) }})</span>
            </span>
            <button wire:click="removeCoupon" class="text-red-500 text-sm hover:underline">Remove</button>
        </div>
    @endif
    @if ($message)
        <p class="mt-2 text-sm text-gray-500">{{ $message }}</p>
    @endif

</div>
