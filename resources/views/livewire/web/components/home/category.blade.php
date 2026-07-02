<div>
    <section class="section ec-category-section ec-category-wrapper-5 section-space-p">
        <div class="container ec-category-wrapper-5">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Most Demanding Categories</h2>
                        <h2 class="ec-title">Categories</h2>
                        <p class="sub-title">Browse The Collection of Top Categories</p>
                    </div>
                </div>
            </div>
            <div class="row cat-space-2 margin-minus-tb-15">
                @forelse ($categories as $cat)
                     <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="cat-card">
                        <img class="cat-icon" src="{{ $cat->image}}" alt="cat-icon">
                        <a class="btn-primary btn-primary-1" href="{{ route('web.filter', ['categories' => [$cat->id]])}}">shop now</a>
                        <div class="cat-detail">
                            <div class="cat-detail-block">
                                <h4>{{$cat->name}}</h4>
                                {{-- <h5>Starting at <br>$79.00</h5> --}}
                                <a class="btn-primary" href="{{ route('web.filter', ['categories' => [$cat->id]]) }}
">shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    We have no any categoires
                @endforelse
                
                
            </div>
        </div>
    </section>
</div>
