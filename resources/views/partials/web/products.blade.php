<div class="shop-pro-content">
    <div class="shop-pro-inner">
        <div class="row">
            @forelse($products as $product)
                <x-product-card :product="$product" :col="4" />
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No products found for these filters.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>



<div class="ec-pro-pagination mt-3">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
