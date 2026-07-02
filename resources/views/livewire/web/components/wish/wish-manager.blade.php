<div>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Wishlist</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Wishlist</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec Wishlist page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <!-- Compare Content Start -->
                <div class="ec-wish-rightside col-lg-12 col-md-12">
                    <!-- Compare content Start -->
                    <div class="ec-compare-content">
                        <div class="ec-compare-inner">
                            <div class="row margin-minus-b-30">
                                @forelse ($products as $product)
                                    <x-product-card :product="$product" />
                                @empty
                                    <p class="text-center">No item in Wish list</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!--compare content End -->
                </div>
                <!-- Compare Content end -->
            </div>
        </div>
    </section>
</div>
