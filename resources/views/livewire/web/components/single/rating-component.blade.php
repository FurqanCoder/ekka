<div>
    <div id="ec-spt-nav-review" class="tab-pane fade show active">
        <div class="row">
            {{-- Existing Reviews --}}
            <div class="ec-t-review-wrapper">
                @forelse ($product->reviews as $review)
                    <div class="ec-t-review-item">
                        <div class="ec-t-review-avtar">
                            <img src="{{ asset('assets/images/review-image/1.jpg') }}" alt="" />
                        </div>

                        <div class="ec-t-review-content">
                            <div class="ec-t-review-top">
                                <div class="ec-t-review-name">{{ $review->user->name }}</div>

                                <div class="ec-t-review-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="ecicon {{ $i <= $review->rating ? 'eci-star fill' : 'eci-star-o' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            <div class="ec-t-review-bottom">
                                <p>{{ $review->review }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                @endforelse

            </div>

            {{-- Add Review Section --}}
            <div class="ec-ratting-content">
                <h3>Add a Review</h3>

                @if (session()->has('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif

                @if (session()->has('error'))
                    <p class="text-danger">{{ session('error') }}</p>
                @endif

                <div class="ec-ratting-form">

                    @auth
                        <div class="ec-ratting-star mb-2">
                            <span>Your rating:</span>

                            <div class="ec-t-review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="ecicon {{ $i <= $rating ? 'eci-star fill' : 'eci-star-o' }}"
                                        style="cursor:pointer" wire:click="setRating({{ $i }})">
                                    </i>
                                @endfor
                            </div>
                        </div>

                        <div class="ec-ratting-input form-submit">
                            <textarea wire:model="review" class="form-control" placeholder="Enter Your Comment"></textarea>

                            @error('review')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <button wire:click="saveReview" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    @else
                        <p class="text-muted">Please <a class="btn btn-primary" wire:click="showLogin">login</a> to add a review.</p>
                    @endauth

                </div>
            </div>

        </div>
    </div>

</div>
