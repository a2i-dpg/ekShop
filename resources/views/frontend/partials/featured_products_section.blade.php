@php
    $featured_products = Cache::remember('featured_products', 3600, function () {
        return filter_products(\App\Models\Product::where('published', 1)->where('featured', '1'))->limit(12)->get();
    });
@endphp

@if (count($featured_products) > 0)
    <section class="feature-product-area">
        <div class="container">
            <div class="bg-white">
                <div class="d-flex align-items-baseline border-bottom mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                    <h3 class="section-title-main fw-600 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Featured Products') }}</span>
                    </h3>
                </div>
                <div class="plx-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-xxs-items="1" data-arrows='true'>
                    @foreach ($featured_products as $key => $product)
                    <div class="carousel-box">
                        @include('frontend.partials.product_box_1',['product' => $product])
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
