@extends('frontend.layouts.app')

@section('meta_title'){{ $shop->meta_title }}@stop

@section('meta_description'){{ $shop->meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $shop->meta_title }}">
    <meta itemprop="description" content="{{ $shop->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($shop->logo) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="website">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $shop->meta_title }}">
    <meta name="twitter:description" content="{{ $shop->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($shop->meta_img) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $shop->meta_title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('shop.visit', $shop->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($shop->logo) }}" />
    <meta property="og:description" content="{{ $shop->meta_description }}" />
    <meta property="og:site_name" content="{{ $shop->name }}" />
@endsection

@section('content')
    <section class="bg-white global-section-area-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="seller-shop-top-area">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="seller-shop-img">
                                <img
                                    class="lazyload"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="@if ($shop->logo !== null) {{ uploaded_asset($shop->logo) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                                    alt="{{ $shop->name }}"
                                >
                            </div>
                            <div class="pl-4 custom-xs-pl-0 d-flex justify-content-center align-items-start flex-column h-100">
                                <h3 class="seller-shop-name">{{ $shop->name }}
                                    @if ($shop->user->seller->verification_status == 1)
                                        <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span>
                                    @else
                                        <span class="ml-2"><i class="fa fa-times-circle" style="color:red"></i></span>
                                    @endif
                                </h3>
                                <div class="rating fs-18 mb-1">
                                    {{ renderStarRating($shop->user->seller->rating) }}
                                </div>
                                <div class="location opacity-60 seller-shop-location">{{ $shop->address }}</div>
                            </div>
                        </div>
                        <ul class="text-center mt-3 social colored list-inline mb-0">
                            @if ($shop->facebook != null)
                                <li class="list-inline-item">
                                    <a href="{{ $shop->facebook }}" class="facebook" target="_blank">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($shop->twitter != null)
                                <li class="list-inline-item">
                                    <a href="{{ $shop->twitter }}" class="twitter" target="_blank">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($shop->google != null)
                                <li class="list-inline-item">
                                    <a href="{{ $shop->google }}" class="google-plus" target="_blank">
                                        <i class="lab la-google"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($shop->youtube != null)
                                <li class="list-inline-item">
                                    <a href="{{ $shop->youtube }}" class="youtube" target="_blank">
                                        <i class="lab la-youtube"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-12 mx-auto">
                    <ul class="list-inline mb-0 text-center border-top border-bottom border-primary text-nowrap overflow-auto">
                        <li class="list-inline-item ">
                            <a class="text-reset d-inline-block fw-600 fs-16 p-3 @if(!isset($type)) text-primary @endif" href="{{ route('shop.visit', $shop->slug) }}">{{ translate('Store Home')}}</a>
                        </li>
                        <li class="list-inline-item ">
                            <a class="text-reset d-inline-block fw-600 fs-16 p-3 @if(isset($type) && $type == 'top-selling') text-primary @endif" href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'top-selling']) }}">{{ translate('Top Selling')}}</a>
                        </li>
                        <li class="list-inline-item ">
                            <a class="text-reset d-inline-block fw-600 fs-16 p-3 @if(isset($type) && $type == 'all-products') text-primary @endif" href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'all-products']) }}">{{ translate('All Products')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @if (!isset($type))
        <section class="global-section-area-bottom">
            <div class="container">
                <div class="plx-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true">
                    @if ($shop->sliders != null)
                        @foreach (explode(',',$shop->sliders) as $key => $slide)
                            <div class="carousel-box home-banner-slider-img">
                                <img class="d-block mw-100 img-fit rounded-25 shadow-sm overflow-hidden" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($slide) }}" alt="{{ $key }} offer">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        <section class="global-section-area-bottom-35">
            <div class="container">
                <div class="text-left">
                    <h3 class="section-title-main fw-600 border-bottom mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Featured Products')}}</span>
                    </h3>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="plx-carousel gutters-10" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-xxs-items="1" data-autoplay='true' data-infinute="true" data-dots="true">
                            @foreach ($shop->user->products->where('published', 1)->where('approved', 1)->where('seller_featured', 1) as $key => $product)
                                <div class="carousel-box">
                                    @include('frontend.partials.product_box_1',['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="global-section-area-bottom">
        <div class="container">
                <h3 class="section-title-main fw-600 border-bottom  mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">
                        @if (!isset($type))
                            {{ translate('New Arrival Products')}}
                        @elseif ($type == 'top-selling')
                            {{ translate('Top Selling')}}
                        @elseif ($type == 'all-products')
                            {{ translate('All Products')}}
                        @endif
                    </span>
                </h3>
            <div class="row gutters-5 row-cols-xxl-5 row-cols-lg-4 row-cols-md-3 row-cols-2">
                @php
                    if (!isset($type)){
                        $products = \App\Models\Product::where('user_id', $shop->user->id)->where('published', 1)->where('approved', 1)->orderBy('created_at', 'desc')->paginate(24);
                    }
                    elseif ($type == 'top-selling'){
                        $products = \App\Models\Product::where('user_id', $shop->user->id)->where('published', 1)->where('approved', 1)->orderBy('num_of_sale', 'desc')->paginate(24);
                    }
                    elseif ($type == 'all-products'){
                        $products = \App\Models\Product::where('user_id', $shop->user->id)->where('published', 1)->where('approved', 1)->paginate(24);
                    }
                @endphp
                @foreach ($products as $key => $product)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 custom-col-xs mb-2">
                        @include('frontend.partials.product_box_1',['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="plx-pagination plx-pagination-center">
                {{ $products->links() }}
            </div>
        </div>
    </section>


@endsection
