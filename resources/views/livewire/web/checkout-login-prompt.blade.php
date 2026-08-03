<!-- resources/views/livewire/web/checkout-login-prompt.blade.php -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fa-solid fa-lock fa-4x text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Login to Checkout</h3>
                    <p class="text-muted mb-4">
                        Please login or create an account to proceed with your order.
                    </p>
                    <div class="d-grid gap-3">
                        <button class="btn btn-primary btn-lg py-3" wire:click="$dispatch('force-login')">
                            <i class="fa-solid fa-sign-in-alt me-2"></i> Login / Signup
                        </button>
                        <a href="{{ route('web-cart') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>