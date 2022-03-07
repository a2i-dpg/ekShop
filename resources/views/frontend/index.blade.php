@extends('frontend.layouts.app')

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
    <div class="home-banner-area pt-3">
        <div class="container">
            <div class="row gutters-10 position-relative">


                @php
                    $num_todays_deal = count($todays_deal_products);
                @endphp

                <div class="@if($num_todays_deal > 0) col-lg-12 @else col-lg-12 @endif">
                    @if (get_setting('home_slider_images') != null)
                        <div class="plx-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true"
                             data-dots="true" data-autoplay="true">
                            @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                            @foreach ($slider_images as $key => $value)
                                <div class="carousel-box home-banner-slider-img">
                                    <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                        <img
                                            class="d-block w-100 rounded-25 shadow-sm overflow-hidden"
                                            src="{{ uploaded_asset($slider_images[$key]) }}"
                                            alt="{{ env('APP_NAME')}} promo"
                                            @if(count($featured_categories) == 0)
                                            height="457"
                                            @else
                                            height="315"
                                            @endif
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                        >
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if (count($featured_categories) > 0)
                        <div class="feature-category-area">
                            <div class="d-flex align-items-baseline mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                                <h3 class="section-title-main fw-600 mb-0">
                                    <span class="d-inline-block">{{ translate('Featured Categories')}}</span>
                                </h3>
                            </div>
                            <ul class="list-unstyled mb-0 row gutters-5">
                                @foreach ($featured_categories as $key => $category)
                                    <li class="minw-0 col-lg-3 col-md-6 col-sm-6 mt-3 single-feature-category-outer">
                                        <a href="{{ route('products.category', $category->slug) }}"
                                           class="d-block single-feature-category">
                                            <div class="feature-category-img">
                                                <img
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($category->banner) }}"
                                                    alt="{{ $category->getTranslation('name') }}"
                                                    class="lazyload img-fit"
                                                    height="78"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                                >
                                            </div>
                                            <div
                                                class="feature-category-name pt-4">{{ $category->getTranslation('name') }}</div>
{{--                                            <div class="feature-category-count">{{ translate('20 Products') }}</div>--}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                @if($num_todays_deal > 0)
                    <div class="col-lg-12">
                        <div class="deals-of-the-day-area">
                            <div class="bg-white">
                                <div class="d-flex align-items-baseline">
                                    <h3 class="section-title-main fw-600 mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                                        <span class="d-inline-block">{{ translate('Deals Of The Day')}}</span>
                                    </h3>
                                </div>
                                <div class="mt-3">
                                    <div class="gutters-5 row">
                                        @foreach ($todays_deal_products as $key => $product)
                                            @if ($product != null)
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-2 deals-custom-mobile-res">
                                                    <div class="position-relative">
                                                        <a href="{{ route('product', $product->slug) }}"
                                                           class="d-block deals-of-the-day-single bg-white rounded">
                                                            <div class="align-items-center">
                                                                <div class="deals-of-the-day-img img">
                                                                    <img
                                                                        class="lazyload img-fit"
                                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                        alt="{{ $product->getTranslation('name') }}"
                                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                    >

                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="deals-of-the-day-single-details">
                                                            <h3 class="mb-0 deals-of-the-day-details-name">
                                                                <div class="d-block">{{  $product->getTranslation('name')  }}</div>
                                                            </h3>
                                                            <div class="rating rating-sm mt-1 deals-of-the-day-details">
                                                                <div class="d-inline-block deals-of-the-day-details-inline">
                                                                    {{ renderStarRating($product->rating) }}
                                                                    <span class="ml-2">( {{ $product->rating }} )</span>
                                                                </div>
                                                                <div class="d-block fs-16">
                                                                    By <span class="text-primary">{{ $product->added_by }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="deals-of-the-day-details-amount d-flex justify-content-between align-items-center">
                                                                <p>
                                                                    <span class="fw-700 text-primary fs-14 mt-2">{{ home_discounted_base_price($product) }}</span>
                                                                    @if(home_base_price($product) != home_discounted_base_price($product))
                                                                        <del class="d-block opacity-70 text-muted fs-14 mt-2">{{ home_base_price($product) }}</del>
                                                                    @endif
                                                                </p>
                                                                <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})"
                                                                   class="btn text-white btn-primary border-primary btn-sm text-center fs-16 mt-3">
                                                                    <i class="las la-shopping-cart"></i> {{ translate('Add to Cart') }}
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Flash Deal --}}
    @php
        $flash_deal = \App\Models\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp
    @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Flash Sale') }}</span>
                        </h3>
                        <div class="plx-count-down ml-auto ml-lg-3 align-items-center"
                             data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                        <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                           class="ml-auto mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{ translate('View More') }}</a>
                    </div>

                    <div class="plx-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                         data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                        @foreach ($flash_deal->flash_deal_products->take(20) as $key => $flash_deal_product)
                            @php
                                $product = \App\Models\Product::find($flash_deal_product->product_id);
                            @endphp
                            @if ($product != null && $product->published != 0)
                                <div class="carousel-box">
                                    @include('frontend.partials.product_box_1',['product' => $product])
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Best Selling  --}}
    {{--    <div id="section_best_selling">--}}
    {{--    <div id="section_best_selling">--}}

    {{--    </div>--}}

    <!-- Auction Product -->
    @if(addon_is_activated('auction'))
        <div id="auction_products">

        </div>
    @endif

    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner2_images') != null)
        <div class="banner-poster-area">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <div class="banner-poster-img-outer">
                                    <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}"
                                       class="d-block text-reset banner-poster-img">
                                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                             data-src="{{ uploaded_asset($banner_2_imags[$key]) }}"
                                             alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Featured Section --}}
    <div id="section_featured">

    </div>

    {{-- Category wise Products --}}
    <div id="section_home_categories">

    </div>

    {{-- Classified Product --}}
    @if(get_setting('classified_product') == 1)
        @php
            $classified_products = \App\Models\CustomerProduct::where('status', '1')->where('published', '1')->take(10)->get();
        @endphp
        @if (count($classified_products) > 0)
            <section class="mb-4">
                <div class="container">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h5 fw-700 mb-0">
                                <span
                                    class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Classified Ads') }}</span>
                            </h3>
                            <a href="{{ route('customer.products') }}"
                               class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                        </div>
                        <div class="plx-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                             data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                            @foreach ($classified_products as $key => $classified_product)
                                <div class="carousel-box">
                                    <div
                                        class="plx-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                        <div class="position-relative">
                                            <a href="{{ route('customer.product', $classified_product->slug) }}"
                                               class="d-block">
                                                <img
                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($classified_product->thumbnail_img) }}"
                                                    alt="{{ $classified_product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                            </a>
                                            <div class="absolute-top-left pt-2 pl-2">
                                                @if($classified_product->conditon == 'new')
                                                    <span
                                                        class="badge badge-inline badge-success">{{translate('new')}}</span>
                                                @elseif($classified_product->conditon == 'used')
                                                    <span
                                                        class="badge badge-inline badge-danger">{{translate('Used')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="p-md-3 p-2 text-left">
                                            <div class="fs-15 mb-1">
                                                <span
                                                    class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                            </div>
                                            <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                   class="d-block text-reset">{{ $classified_product->getTranslation('name') }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner3_images') != null)
        <div class="banner-poster-area">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                    @foreach ($banner_3_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}"
                                   class="d-block text-reset banner-poster-img">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                         data-src="{{ uploaded_asset($banner_3_imags[$key]) }}"
                                         alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Banner section 1 --}}
{{--    @if (get_setting('home_banner1_images') != null)--}}
{{--        <div class="banner-poster-area">--}}
{{--            <div class="container">--}}
{{--                <div class="row gutters-10">--}}
{{--                    @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp--}}
{{--                    @foreach ($banner_1_imags as $key => $value)--}}
{{--                        <div class="col-xl col-md-6">--}}
{{--                            <div class="mb-3 mb-lg-0">--}}
{{--                                <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}"--}}
{{--                                   class="d-block text-reset banner-poster-img">--}}
{{--                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"--}}
{{--                                         data-src="{{ uploaded_asset($banner_1_imags[$key]) }}"--}}
{{--                                         alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    {{-- Top 10 categories and Brands --}}
    @if (get_setting('top10_categories') != null && get_setting('top10_brands') != null)
        <section class="top-10-area">
            <div class="container">
                <div class="row gutters-10">
                    @if (get_setting('top10_brands') != null)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="d-flex mb-3 align-items-baseline border-bottom">
                                <h3 class="section-title-main fw-600 mb-0">
                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top 10 Brands') }}</span>
                                </h3>
                                {{--                            <a href="{{ route('brands.all') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View All Brands') }}</a>--}}
                            </div>
                            <div class="pt-lg-3 pt-md-2 pt-sm-1">
                                <div class="single-top-10-scroll">
                                    <div class="row gutters-5">
                                        @php $top10_brands = json_decode(get_setting('top10_brands')); @endphp
                                        @foreach ($top10_brands as $key => $value)
                                            @php $brand = \App\Models\Brand::find($value); @endphp
                                            @if ($brand != null)
                                                <div class="col-sm-12">
                                                    <a href="{{ route('products.brand', $brand->slug) }}"
                                                       class="bg-white d-block text-reset p-2 rounded hov-shadow-md mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="top-10-img text-center border rounded">
                                                                <img
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($brand->logo) }}"
                                                                    alt="{{ $brand->getTranslation('name') }}"
                                                                    class="img lazyload rounded"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                >
                                                            </div>
                                                            <div class="top-10-text">
                                                                <div
                                                                    class="text-truncate-2 pl-3 fs-18 fw-600 text-left">{{ $brand->getTranslation('name') }}</div>
                                                            </div>
                                                            
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (get_setting('top10_categories') != null)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="d-flex mb-3 align-items-baseline border-bottom">
                                <h3 class="section-title-main fw-600 mb-0">
                                    <span
                                        class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top 10 Categories') }}</span>
                                </h3>
                            </div>
                            <div class="pt-lg-3 pt-md-2 pt-sm-1">
                                <div class="single-top-10-scroll">
                                    <div class="row gutters-5">
                                        @php $top10_categories = json_decode(get_setting('top10_categories')); @endphp
                                        @foreach ($top10_categories as $key => $value)
                                            @php $category = \App\Models\Category::find($value); @endphp
                                            @if ($category != null)
                                                <div class="col-sm-12">
                                                    <a href="{{ route('products.category', $category->slug) }}"
                                                       class="bg-white d-block text-reset rounded p-2 hov-shadow-md mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="top-10-img text-center border rounded">
                                                                <img
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($category->banner) }}"
                                                                    alt="{{ $category->getTranslation('name') }}"
                                                                    class="img lazyload rounded"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                >
                                                            </div>
                                                            <div class="top-10-text">
                                                                <div
                                                                    class="text-truncat-2 pl-3 fs-18 fw-600 text-left">{{ $category->getTranslation('name') }}</div>
                                                            </div>
                                                            
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @php
                            $best_selling_products = Cache::remember('best_selling_products', 86400, function () {
                                return filter_products(\App\Models\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->limit(20)->get();
                            });
                        @endphp

                        @if (get_setting('best_selling') == 1)
                            <section class="top-10-selling">
                                <div class="">
                                    <div class="bg-white">
                                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                                            <h3 class="section-title-main fw-600 mb-0">
                                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top 10 Selling') }}</span>
                                            </h3>
                                        </div>
                                        <div class="pt-lg-3 pt-md-2 pt-sm-1">
                                            <div class="single-top-10-scroll">
                                                <div class="row gutters-5">
                                                    @foreach ($best_selling_products as $key => $product)
                                                        <div class="col-sm-12">
                                                            <div class="carousel-box">
                                                                <a href="{{ route('product', $product->slug) }}"
                                                                   class="bg-white d-block text-reset rounded p-2 hov-shadow-md mb-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="top-10-img text-center border rounded">
                                                                            <img
                                                                                class="img lazyload rounded"
                                                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                alt="{{  $product->getTranslation('name')  }}"
                                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                            >
                                                                        </div>
                                                                        <div class="text-left">
                                                                            <h3 class="top-10-text">
                                                                        <span
                                                                            class="text-truncate-2 pl-3 fs-18 fw-600 text-left">{{  $product->getTranslation('name')  }}</span>
                                                                                <div
                                                                                    class="rating rating-sm mt-1 pl-3 top-10-selling-rating">
                                                                                    {{ renderStarRating($product->rating) }}
                                                                                </div>
                                                                                <div class="pl-3 top-10-selling-amount">
                                                                                    @if(home_base_price($product) != home_discounted_base_price($product))
                                                                                        <del
                                                                                            class="fw-600 opacity-50 mr-1 text-muted">{{ home_base_price($product) }}</del>
                                                                                    @endif
                                                                                    <span
                                                                                        class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
                                                                                </div>
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Best Seller --}}
    <div id="section_best_sellers">

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $.post('{{ route('home.section.featured') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_featured').html(data);
                PLX.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_best_selling').html(data);
                PLX.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.auction_products') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#auction_products').html(data);
                PLX.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_home_categories').html(data);
                PLX.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_sellers') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_best_sellers').html(data);
                PLX.plugins.slickCarousel();
            });
        });
    </script>
@endsection
