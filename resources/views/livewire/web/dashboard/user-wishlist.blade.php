<!-- resources/views/livewire/web/dashboard/user-wishlist.blade.php -->
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">My Wishlist</h5>
        <span class="text-muted">{{ count($wishlistItems) }} items</span>
    </div>

    @if(count($wishlistItems) > 0)
        <div class="row g-3">
            @foreach($wishlistItems as $item)
                <div class="col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="position-relative">
                            <img src="{{ $item['image'] }}" 
                                 alt="{{ $item['name'] }}" 
                                 class="card-img-top rounded-top-4"
                                 style="height: 200px; object-fit: cover;">
                            <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" 
                                    wire:click="removeFromWishlist({{ $item['id'] }})"
                                    style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            @if($item['in_stock'])
                                <span class="badge bg-success position-absolute bottom-0 start-0 m-2">In Stock</span>
                            @else
                                <span class="badge bg-danger position-absolute bottom-0 start-0 m-2">Out of Stock</span>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1 text-truncate">
                                <a href="{{ route('web-product', $item['slug']) }}" class="text-decoration-none text-dark">
                                    {{ $item['name'] }}
                                </a>
                            </h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($item['original_price'] && $item['price'] < $item['original_price'])
                                        <span class="text-muted text-decoration-line-through small">
                                            Rs. {{ number_format($item['original_price'], 0) }}
                                        </span>
                                    @endif
                                    <span class="fw-bold text-primary">
                                        Rs. {{ number_format($item['price'], 0) }}
                                    </span>
                                </div>
                                <button class="btn btn-primary btn-sm" 
                                        wire:click="addToCart({{ $item['product_id'] }})"
                                        @if(!$item['in_stock']) disabled @endif>
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted">Added {{ $item['added_at'] }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fa-solid fa-heart fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">Your wishlist is empty</h6>
            <p class="text-muted small">Start adding products you love!</p>
            <a href="" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Start Shopping
            </a>
        </div>
    @endif
</div>