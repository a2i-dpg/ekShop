@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency" content="{{ \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')
    <section class="global-section-area-bottom pt-3">
        <div class="container">
            <div class="bg-white pt-3">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-5">
                            @php
                                $photos = explode(',', $detailedProduct->photos);
                            @endphp
                            <div class="col order-1 order-md-2 border rounded h-100 p-3">
                                <div class="plx-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'>
                                    @foreach ($photos as $key => $photo)
                                        <div class="carousel-box img-zoom rounded">
                                            <img
                                                class="img-fluid lazyload"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                            >
                                        </div>
                                    @endforeach
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box img-zoom rounded">
                                                <img
                                                    class="img-fluid lazyload"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-md-auto w-md-80px order-2 order-md-1 mt-3 mt-md-0">
                                <div class="plx-carousel product-gallery-thumb" data-items='5' data-nav-for='.product-gallery' data-vertical='true' data-vertical-sm='false' data-focus-select='true' data-arrows='true'>
                                    @foreach ($photos as $key => $photo)
                                    <div class="carousel-box c-pointer border p-1 rounded">
                                        <img
                                            class="lazyload mw-100 size-50px mx-auto"
                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($photo) }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                        >
                                    </div>
                                    @endforeach
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box c-pointer border p-1 rounded" data-variation="{{ $stock->variant }}">
                                                <img
                                                    class="lazyload mw-100 size-50px mx-auto"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-6">
                        <div class="text-left">
                            <h1 class="mb-1 product-details-name">
                                {{ $detailedProduct->getTranslation('name') }}
                            </h1>

                            <div class="row align-items-center">
                                <div class="col-12">
                                    @php
                                        $total = 0;
                                        $total += $detailedProduct->reviews->count();
                                    @endphp
                                    <span class="rating">
                                        {{ renderStarRating($detailedProduct->rating) }}
                                    </span>
                                    <span class="ml-1 opacity-50">({{$total}} {{ translate('.0')}})</span>
                                </div>
                                @if ($detailedProduct->est_shipping_days)
                                <div class="col-auto ml">
                                    <small class="mr-2 opacity-50">{{ translate('Estimate Shipping Time')}}: </small>{{ $detailedProduct->est_shipping_days }} {{  translate('Days') }}
                                </div>
                                @endif
                            </div>

                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <small class="mr-2 opacity-50 fs-14">{{ translate('Sold by ')}} : </small>
                                    @if ($detailedProduct->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                                        <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}" class="text-primary fw-600 fs-14 ml-1">{{ $detailedProduct->user->shop->name }}</a>
                                    @else
                                        <span class="text-primary fw-600 fs-14 ml-1">
                                            {{  translate('Inhouse product') }}
                                        </span>
                                    @endif
                                </div>
                                @if ($detailedProduct->brand != null)
                                    <div class="col-auto">
                                        <a href="{{ route('products.brand',$detailedProduct->brand->slug) }}" class="product-brand-logo">
                                            <img src="{{ uploaded_asset($detailedProduct->brand->logo) }}" alt="{{ $detailedProduct->brand->getTranslation('name') }}"class="product-brand-logo">
                                        </a>
                                    </div>
                                @endif
{{--                                @if (get_setting('conversation_system') == 1)--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <button class="btn btn-sm btn-soft-primary" onclick="show_chat_modal()">{{ translate('Message Seller')}}</button>--}}
{{--                                    </div>--}}
{{--                                @endif--}}


                                @if (get_setting('conversation_system') == 1)
                                    <div class="col-12">
                                        <button class="btn btn-sm bg-white border-0 fs-16 fw-500 text-primary pl-0 mb-2" onclick="show_chat_modal()">
                                            <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 3.28345H4C2.897 3.28345 2 4.18045 2 5.28345V17.2834C2 18.3864 2.897 19.2834 4 19.2834H7V23.0504L13.277 19.2834H20C21.103 19.2834 22 18.3864 22 17.2834V5.28345C22 4.18045 21.103 3.28345 20 3.28345ZM20 17.2834H12.723L9 19.5164V17.2834H4V5.28345H20V17.2834Z" fill="#92278F"/>
                                                <path d="M7 8.28345H17V10.2834H7V8.28345ZM7 12.2834H14V14.2834H7V12.2834Z" fill="#92278F"/>
                                            </svg> {{ translate('Message Seller')}}
                                        </button>
                                    </div>
                                @endif
                            </div>

                            @if ($detailedProduct->wholesale_product)
                                <table class="plx-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Min Qty') }}</th>
                                            <th>{{ translate('Max Qty') }}</th>
                                            <th>{{ translate('Unit Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detailedProduct->stocks->first()->wholesalePrices as $wholesalePrice)
                                            <tr>
                                                <td>{{ $wholesalePrice->min_qty }}</td>
                                                <td>{{ $wholesalePrice->max_qty }}</td>
                                                <td>{{ single_price($wholesalePrice->price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                @if(home_price($detailedProduct) != home_discounted_price($detailedProduct))
                                    <div class="row no-gutters">
                                        {{--                                        <div class="col-sm-2">--}}
                                        {{--                                            <div class="opacity-50">{{ translate('Discount Price')}}:</div>--}}
                                        {{--                                        </div>--}}
                                        <div class="col-sm-10">
                                            <div class="">
                                                <strong class="h2 fw-600 text-primary">
                                                    {{ home_discounted_price($detailedProduct) }}
                                                </strong>
                                                @if($detailedProduct->unit != null)
                                                    <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-1">
                                        <div class="price-title mr-3">
                                            <div class="fs-18 fw-600">{{ translate('Regular Price')}}:</div>
                                        </div>
                                        <div class="price-amount">
                                            <div class="fs-20 opacity-60">
                                                <del>
                                                    {{ home_price($detailedProduct) }}
                                                    @if($detailedProduct->unit != null)
                                                        <span>/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                    @endif
                                                </del>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex mt-3">
                                        <div class="price-title mr-3">
                                            <div class="opacity-50 my-2">{{ translate('Price')}}:</div>
                                        </div>
                                        <div class="price-amount">
                                            <div class="">
                                                <strong class="h2 fw-600 text-primary">
                                                    {{ home_discounted_price($detailedProduct) }}
                                                </strong>
                                                @if($detailedProduct->unit != null)
                                                    <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if (addon_is_activated('club_point') && $detailedProduct->earn_point > 0)
                                <div class="d-flex mt-4">
                                    <div class="price-title">
                                        <div class="opacity-50 my-2">{{  translate('Club Point') }}:</div>
                                    </div>
                                    <div class="price-amount">
                                        <div class="d-inline-block rounded px-2 bg-soft-primary border-soft-primary border">
                                            <span class="strong-700">{{ $detailedProduct->earn_point }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form id="option-choice-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                                @if ($detailedProduct->choice_options != null)
                                    @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)

                                    <div class="d-flex">
                                        <div class="price-title">
                                            <div class="opacity-50 my-2">{{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</div>
                                        </div>
                                        <div class="price-amount">
                                            <div class="plx-radio-inline">
                                                @foreach ($choice->values as $key => $value)
                                                <label class="plx-megabox pl-0 mr-2">
                                                    <input
                                                        type="radio"
                                                        name="attribute_id_{{ $choice->attribute_id }}"
                                                        value="{{ $value }}"
                                                        @if($key == 0) checked @endif
                                                    >
                                                    <span class="plx-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                        {{ $value }}
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                @endif

                                @if (count(json_decode($detailedProduct->colors)) > 0)
                                    <div class="d-flex mt-3">
                                        <div class="price-title">
                                            <div class="fs-18 fw-600">{{ translate('Color')}}:</div>
                                        </div>
                                        <div class="price-amount">
                                            <div class="plx-radio-inline mt-1">
                                                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                <label class="plx-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Models\Color::where('code', $color)->first()->name }}">
                                                    <input
                                                        type="radio"
                                                        name="color"
                                                        value="{{ \App\Models\Color::where('code', $color)->first()->name }}"
                                                        @if($key == 0) checked @endif
                                                    >
                                                    <span class="plx-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                        <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Quantity + Add to cart -->
                                <div class="d-flex mt-3 flex-wrap">

                                    <div class="price-title mr-3">
                                        <div class="product-quantity d-flex align-items-center">
                                            <div class="product-details-quantity plx-plus-minus mr-3">
                                                <button class="btn minus" type="button" data-type="minus" data-field="quantity" disabled="">
                                                    <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 1L6 6L11 1" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>

                                                </button>
                                                <input type="number" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}" max="10">
                                                <button class="btn plus" type="button" data-type="plus" data-field="quantity">
                                                    <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11 6L6 1L1 6" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>

                                                </button>
                                            </div>
                                            @php
                                                $qty = 0;
                                                foreach ($detailedProduct->stocks as $key => $stock) {
                                                    $qty += $stock->qty;
                                                }
                                            @endphp
                                            <div class="avialable-amount opacity-60">
                                                @if($detailedProduct->stock_visibility_state == 'quantity')
                                                (<span id="available-quantity">{{ $qty }}</span> {{ translate('available')}})
                                                @elseif($detailedProduct->stock_visibility_state == 'text' && $qty >= 1)
                                                    (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price-amount" id="chosen_price_div">

                                        <div class="d-flex justify-content-start align-items-center h-100">
                                            <div class="product-price">
                                                <strong id="chosen_price" class="h4 fw-600 text-primary">

                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <div class="mt-4">
                                @if ($detailedProduct->external_link != null)
                                    <a type="button" class="btn btn-primary mr-2 add-to-cart add-to-cart-button fw-600 fs-16" href="{{ $detailedProduct->external_link }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                            <path d="M7.12467 17.4153C7.5619 17.4153 7.91634 17.0612 7.91634 16.6243C7.91634 16.1874 7.5619 15.8333 7.12467 15.8333C6.68745 15.8333 6.33301 16.1874 6.33301 16.6243C6.33301 17.0612 6.68745 17.4153 7.12467 17.4153Z" stroke="white" stroke-width="1.47752" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M15.8337 17.4153C16.2709 17.4153 16.6253 17.0612 16.6253 16.6243C16.6253 16.1874 16.2709 15.8333 15.8337 15.8333C15.3964 15.8333 15.042 16.1874 15.042 16.6243C15.042 17.0612 15.3964 17.4153 15.8337 17.4153Z" stroke="white" stroke-width="1.47752" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M0.791992 0.79126H3.95866L6.08033 11.3917C6.15272 11.7562 6.351 12.0836 6.64047 12.3166C6.92993 12.5496 7.29213 12.6734 7.66366 12.6663H15.3587C15.7302 12.6734 16.0924 12.5496 16.3819 12.3166C16.6713 12.0836 16.8696 11.7562 16.942 11.3917L18.2087 4.74959H4.75033" stroke="white" stroke-width="1.47752" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
                                    </a>
                                    <a type="button" class="btn btn-action-button mr-2 buy-now buy-now-button fw-600 fs-16" href="{{ $detailedProduct->external_link }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                            <path d="M4.75 1.58325L2.375 4.74992V15.8333C2.375 16.2532 2.54181 16.6559 2.83875 16.9528C3.13568 17.2498 3.53841 17.4166 3.95833 17.4166H15.0417C15.4616 17.4166 15.8643 17.2498 16.1613 16.9528C16.4582 16.6559 16.625 16.2532 16.625 15.8333V4.74992L14.25 1.58325H4.75Z" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M2.375 4.75H16.625" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12.6668 7.91675C12.6668 8.7566 12.3332 9.56205 11.7393 10.1559C11.1455 10.7498 10.34 11.0834 9.50016 11.0834C8.66031 11.0834 7.85486 10.7498 7.26099 10.1559C6.66713 9.56205 6.3335 8.7566 6.3335 7.91675" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                        <span class="d-none d-md-inline-block">{{ translate('Buy Now')}}</span>
                                    </a>
                                @else
                                    <button type="button" class="btn btn-primary mr-2 add-to-cart add-to-cart-button fw-600 fs-16" onclick="addToCart()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                            <path d="M7.12467 17.4153C7.5619 17.4153 7.91634 17.0612 7.91634 16.6243C7.91634 16.1874 7.5619 15.8333 7.12467 15.8333C6.68745 15.8333 6.33301 16.1874 6.33301 16.6243C6.33301 17.0612 6.68745 17.4153 7.12467 17.4153Z" stroke="white" stroke-width="1.47752" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M15.8337 17.4153C16.2709 17.4153 16.6253 17.0612 16.6253 16.6243C16.6253 16.1874 16.2709 15.8333 15.8337 15.8333C15.3964 15.8333 15.042 16.1874 15.042 16.6243C15.042 17.0612 15.3964 17.4153 15.8337 17.4153Z" stroke="white" stroke-width="1.47752" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M0.791992 0.79126H3.95866L6.08033 11.3917C6.15272 11.7562 6.351 12.0836 6.64047 12.3166C6.92993 12.5496 7.29213 12.6734 7.66366 12.6663H15.3587C15.7302 12.6734 16.0924 12.5496 16.3819 12.3166C16.6713 12.0836 16.8696 11.7562 16.942 11.3917L18.2087 4.74959H4.75033" stroke="white" stroke-width="1.47752" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
                                    </button>
                                    <button type="button" class="btn btn-action-button mr-2 buy-now buy-now-button fw-600 fs-16" onclick="buyNow()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                            <path d="M4.75 1.58325L2.375 4.74992V15.8333C2.375 16.2532 2.54181 16.6559 2.83875 16.9528C3.13568 17.2498 3.53841 17.4166 3.95833 17.4166H15.0417C15.4616 17.4166 15.8643 17.2498 16.1613 16.9528C16.4582 16.6559 16.625 16.2532 16.625 15.8333V4.74992L14.25 1.58325H4.75Z" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M2.375 4.75H16.625" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12.6668 7.91675C12.6668 8.7566 12.3332 9.56205 11.7393 10.1559C11.1455 10.7498 10.34 11.0834 9.50016 11.0834C8.66031 11.0834 7.85486 10.7498 7.26099 10.1559C6.66713 9.56205 6.3335 8.7566 6.3335 7.91675" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                        <span class="d-none d-md-inline-block">{{ translate('Buy Now')}}</span>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-secondary out-of-stock fw-600 d-none fs-16 cursor-no-drop" disabled>
                                    <i class="la la-cart-arrow-down fs-18"></i> {{ translate('Out of Stock')}}
                                </button>

                                <button type="button" class="btn product-details-compare fw-600 fs-16 mr-2 border" onclick="addToCompare({{ $detailedProduct->id }})">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 1L21 5L17 9" stroke="#BFBFBF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 11V9C3 7.93913 3.42143 6.92172 4.17157 6.17157C4.92172 5.42143 5.93913 5 7 5H21" stroke="#BFBFBF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7 23L3 19L7 15" stroke="#BFBFBF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 13V15C21 16.0609 20.5786 17.0783 19.8284 17.8284C19.0783 18.5786 18.0609 19 17 19H3" stroke="#BFBFBF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn product-details-compare fw-600 fs-16 border" onclick="addToWishList({{ $detailedProduct->id }})">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.8401 4.61012C20.3294 4.09912 19.7229 3.69376 19.0555 3.4172C18.388 3.14064 17.6726 2.99829 16.9501 2.99829C16.2276 2.99829 15.5122 3.14064 14.8448 3.4172C14.1773 3.69376 13.5709 4.09912 13.0601 4.61012L12.0001 5.67012L10.9401 4.61012C9.90843 3.57842 8.50915 2.99883 7.05012 2.99883C5.59109 2.99883 4.19181 3.57842 3.16012 4.61012C2.12843 5.64181 1.54883 7.04108 1.54883 8.50012C1.54883 9.95915 2.12843 11.3584 3.16012 12.3901L4.22012 13.4501L12.0001 21.2301L19.7801 13.4501L20.8401 12.3901C21.3511 11.8794 21.7565 11.2729 22.033 10.6055C22.3096 9.93801 22.4519 9.2226 22.4519 8.50012C22.4519 7.77763 22.3096 7.06222 22.033 6.39476C21.7565 5.7273 21.3511 5.12087 20.8401 4.61012V4.61012Z" fill="white" stroke="#BFBFBF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>



                            <div class="d-table width-100 mt-2">
                                <div class="d-table-cell">
                                    <!-- Add to wishlist button -->

                                    @if(Auth::check() && addon_is_activated('affiliate_system') && (\App\AffiliateOption::where('type', 'product_sharing')->first()->status || \App\AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                                        @php
                                            if(Auth::check()){
                                                if(Auth::user()->referral_code == null){
                                                    Auth::user()->referral_code = substr(Auth::user()->id.Str::random(10), 0, 10);
                                                    Auth::user()->save();
                                                }
                                                $referral_code = Auth::user()->referral_code;
                                                $referral_code_url = URL::to('/product').'/'.$detailedProduct->slug."?product_referral_code=$referral_code";
                                            }
                                        @endphp
                                        <div>
                                            <button type=button id="ref-cpurl-btn" class="btn btn-sm btn-secondary" data-attrcpy="{{ translate('Copied')}}" onclick="CopyToClipboard(this)" data-url="{{$referral_code_url}}">{{ translate('Copy the Promote Link')}}</button>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            @php
                                $refund_sticker = get_setting('refund_sticker');
                            @endphp
                            @if (addon_is_activated('refund_request'))
                                <div class="row no-gutters mt-2">
                                    <div class="col-2">
                                        <div class="opacity-50 mt-2">{{ translate('Refund')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <a href="{{ route('returnpolicy') }}" target="_blank">
                                            @if ($refund_sticker != null)
                                                <img src="{{ uploaded_asset($refund_sticker) }}" height="36">
                                            @else
                                                <img src="{{ static_asset('assets/img/refund-sticker.jpg') }}" height="36">
                                            @endif</a>
                                        <a href="{{ route('returnpolicy') }}" class="ml-2" target="_blank">{{ translate('View Policy') }}</a>
                                    </div>
                                </div>
                            @endif
                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <div class="fs-18 fw-600">{{ translate('Share')}}:</div>
                                </div>
                                <div class="col-12">
                                    <div class="plx-share mt-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="global-section-area-bottom">
        <div class="container">
            <div class="global-section-area-bottom">
                <div class="row gutters-10">
                    <div class="col-xl-7 col-lg-7 col-md-12">
                        <div class="bg-white product-details-tab-area">
                            <div class="nav border-bottom plx-nav-tabs product-details-tab-active">
                                <a href="#tab_default_1" data-toggle="tab" class="py-3 pr-3 pl-0 section-title fw-600 text-reset active show">{{ translate('Description')}}</a>
                                @if($detailedProduct->video_link != null)
                                    <a href="#tab_default_2" data-toggle="tab" class="p-3 section-title fw-600 text-reset">{{ translate('Video')}}</a>
                                @endif
                                @if($detailedProduct->pdf != null)
                                    {{--                                <a href="#tab_default_3" data-toggle="tab" class="p-3 section-title fw-600 text-reset">{{ translate('Downloads')}}</a>--}}
                                @endif
                                <a href="#tab_default_4" data-toggle="tab" class="p-3 section-title fw-600 text-reset">{{ translate('Reviews')}}</a>
                            </div>

                            <div class="tab-content pt-0">
                                <div class="tab-pane fade active show" id="tab_default_1">
                                    <div class="pt-4">
                                        <div class="mw-100 overflow-hidden text-left plx-editor-data fs-16">
                                            <?php echo $detailedProduct->getTranslation('description'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab_default_2">
                                    <div class="pt-4">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ explode('=', $detailedProduct->video_link)[1] }}"></iframe>
                                            @elseif ($detailedProduct->video_provider == 'dailymotion' && isset(explode('video/', $detailedProduct->video_link)[1]))
                                                <iframe class="embed-responsive-item" src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                                            @elseif ($detailedProduct->video_provider == 'vimeo' && isset(explode('vimeo.com/', $detailedProduct->video_link)[1]))
                                                <iframe src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_3">
                                    <div class="pt-4 text-center ">
                                        <a href="{{ uploaded_asset($detailedProduct->pdf) }}" class="btn btn-primary">{{  translate('Download') }}</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_4">
                                    <div class="pt-4">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($detailedProduct->reviews as $key => $review)
                                                @if($review->user != null)
                                                    <li class="media list-group-item d-flex">
                                                <span class="avatar avatar-md mr-3">
                                                    <img
                                                        class="lazyload"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                        @if($review->user->avatar_original !=null)
                                                        data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                                        @else
                                                        data-src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        @endif
                                                    >
                                                </span>
                                                        <div class="media-body text-left">
                                                            <div class="d-flex justify-content-between">
                                                                <h3 class="fs-16 fw-600 mb-0">{{ $review->user->name }}</h3>
                                                                <span class="rating rating-sm">
                                                            @for ($i=0; $i < $review->rating; $i++)
                                                                        <i class="las la-star active"></i>
                                                                    @endfor
                                                                    @for ($i=0; $i < 5-$review->rating; $i++)
                                                                        <i class="las la-star"></i>
                                                                    @endfor
                                                        </span>
                                                            </div>
                                                            <div class="opacity-60 mb-2">{{ date('d-m-Y', strtotime($review->created_at)) }}</div>
                                                            <p class="comment-text">
                                                                {{ $review->comment }}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>

                                        @if(count($detailedProduct->reviews) <= 0)
                                            <div class="text-center fs-18 opacity-70">
                                                {{  translate('There have been no reviews for this product yet.') }}
                                            </div>
                                        @endif

                                        @if(Auth::check())
                                            @php
                                                $commentable = false;
                                            @endphp
                                            @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                                @if($orderDetail->order != null && $orderDetail->order->user_id == Auth::user()->id && $orderDetail->delivery_status == 'delivered' && \App\Models\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                                    @php
                                                        $commentable = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if ($commentable)
                                                <div class="pt-4">
                                                    <div class="border-bottom mb-4">
                                                        <h3 class="fs-18 fw-600">
                                                            {{ translate('Write a review')}}
                                                        </h3>
                                                    </div>
                                                    <form class="form-default" role="form" action="{{ route('reviews.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="text-uppercase c-gray-light">{{ translate('Your name')}}</label>
                                                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" disabled required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="text-uppercase c-gray-light">{{ translate('Email')}}</label>
                                                                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" required disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="opacity-60">{{ translate('Rating')}}</label>
                                                            <div class="rating rating-input">
                                                                <label>
                                                                    <input type="radio" name="rating" value="1" required>
                                                                    <i class="las la-star"></i>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="rating" value="2">
                                                                    <i class="las la-star"></i>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="rating" value="3">
                                                                    <i class="las la-star"></i>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="rating" value="4">
                                                                    <i class="las la-star"></i>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="rating" value="5">
                                                                    <i class="las la-star"></i>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="opacity-60">{{ translate('Comment')}}</label>
                                                            <textarea class="form-control" rows="4" name="comment" placeholder="{{ translate('Your review')}}" required></textarea>
                                                        </div>

                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-primary mt-3">
                                                                {{ translate('Submit review')}}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-12 order-1 order-xl-0">
                        <div class="bg-white">
                            <div class="d-flex align-items-baseline border-bottom pt-3">
                                <h3 class="fw-600 mb-0 section-title">
                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Add Review') }}</span>
                                </h3>
                            </div>
                            <div class="add-review-area pt-3">
                                <form class="form-default" role="form" action="{{ route('reviews.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="">
                                    <div class="form-group">
                                        <input type="text" name="name" value="" class="form-control" placeholder="{{ translate('Full Name')}}" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" value="" class="form-control" placeholder="{{ translate('Email Address')}}" required />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" name="comment" placeholder="{{ translate('Write a commnet')}}" required></textarea>
                                    </div>
                                    <div class="form-group text-left">
                                        <button type="submit" class="btn btn-primary">
                                            {{ translate('Submit')}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="global-section-area-bottom">
                <div class="row gutters-10">
                    <div class="col-12">
                        <div class="bg-white">
                            <div class="pb-3">
                                <h3 class="fw-600 mb-0 section-title">
                                    <span class="mr-4">{{ translate('Top Related Products')}}</span>
                                </h3>
                            </div>
                            <div class="">
                                <div class="plx-carousel gutters-5 half-outside-arrow" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-xxs-items="1" data-arrows='true' data-infinite='true'>
                                    @foreach (filter_products(\App\Models\Product::where('category_id', $detailedProduct->category_id)->where('id', '!=', $detailedProduct->id))->limit(10)->get() as $key => $related_product)
                                        <div class="carousel-box">
                                            <div class="plx-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                                <div class="">
                                                    <a href="{{ route('product', $related_product->slug) }}" class="d-block">
                                                        <div class="product-img-inner">
                                                            {{-- <img
                                                                class="img-fit lazyloaded"
                                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                                                                alt="{{ $related_product->getTranslation('name') }}"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            > --}}
                                                            <img
                                                            class="img lazyload rounded"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                                                            alt="{{ $related_product->getTranslation('name') }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            >


                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="category-product-body-area text-center">
                                                    <div class="category-product-amount">
                                                        @if(home_base_price($related_product) != home_discounted_base_price($related_product))
                                                            <del class="fw-600 opacity-50 mr-1 text-muted">{{ home_base_price($related_product) }}</del>
                                                        @endif
                                                        <span class="fw-700 text-primary">{{ home_discounted_base_price($related_product) }}</span>
                                                    </div>
                                                    <h3 class="mb-0 category-product-name">
                                                        <a href="{{ route('product', $related_product->slug) }}" class="d-block text-3d3d3d fw-600">{{ $related_product->getTranslation('name') }}</a>
                                                    </h3>
                                                    <div class="rating rating-sm mt-1 top-10-selling-rating text-center">
                                                        By <span class="text-primary">Dpg</span> {{ renderStarRating($related_product->rating) }}
                                                    </div>
                                                    <a href="javascript:void(0)" onclick="showAddToCartModal({{ $related_product->id }})" class="btn btn-primary text-white border-primary btn-sm text-center fs-16 mt-3">
                                                        <i class="las la-shopping-cart"></i> {{ translate('Add to Cart') }}
                                                    </a>
                                                    @if (addon_is_activated('club_point'))
                                                        <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                            {{ translate('Club Point') }}:
                                                            <span class="fw-700 float-right">{{ $related_product->earn_point }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row gutters-10">
                    <div class="col-12">

                        <div class="bg-white">
                            <div class="d-flex align-items-baseline border-bottom pt-3">
                                <h3 class="fw-600 mb-0 section-title border-bottom">
                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top Selling Products') }}</span>
                                </h3>
                                <a href="javascript:void(0)" class="ml-auto mr-0 bg-white text-primary fs-16 fw-500">{{ translate('View All') }}</a> <i class="las la-angle-right"></i>
                            </div>

                            <!-- Div Start -->
                            {{-- <div class="">
                                <div class="plx-carousel gutters-5 half-outside-arrow" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-xxs-items="1" data-arrows='true' data-infinite='true'>
                                    @foreach (filter_products(\App\Models\Product::where('user_id', $detailedProduct->user_id)->orderBy('num_of_sale', 'desc'))->limit(6)->get() as $key => $top_product)
                                        <div class="carousel-box">
                                            <div class="plx-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                                <div class="">
                                                    <a href="{{ route('product', $top_product->slug) }}" class="bg-white d-block text-reset rounded p-2 hov-shadow-md mb-2">
                                                        <div class="product-img-inner">
                                                            <img
                                                            class="img lazyload rounded"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            data-src="{{ uploaded_asset($top_product->thumbnail_img) }}"
                                                            alt="{{ $top_product->getTranslation('name') }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            >
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="category-product-body-area text-center">
                                                    <div class="category-product-amount">
                                                        @if(home_base_price($top_product) != home_discounted_base_price($top_product))
                                                            <del class="fw-600 opacity-50 mr-1 text-muted">{{ home_base_price($top_product) }}</del>
                                                        @endif
                                                        <span class="fw-700 text-primary">{{ home_discounted_base_price($top_product) }}</span>
                                                    </div>
                                                    <h3 class="mb-0 category-product-name">
                                                        <a href="{{ route('product', $top_product->slug) }}" class="d-block text-3d3d3d fw-600">{{ $top_product->getTranslation('name') }}</a>
                                                    </h3>
                                                    <div class="rating rating-sm mt-1 top-10-selling-rating text-center">
                                                        By <span class="text-primary">Dpg</span> {{ renderStarRating($top_product->rating) }}
                                                    </div>
                                                    <a href="javascript:void(0)" onclick="showAddToCartModal({{ $top_product->id }})" class="btn btn-primary text-white border-primary btn-sm text-center fs-16 mt-3">
                                                        <i class="las la-shopping-cart"></i> {{ translate('Add to Cart') }}
                                                    </a>
                                                    @if (addon_is_activated('club_point'))
                                                        <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                            {{ translate('Club Point') }}:
                                                            <span class="fw-700 float-right">{{ $top_product->earn_point }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div> --}}
                            <!-- Div End -->


                            <div class="row mt-3">
                                @foreach (filter_products(\App\Models\Product::where('user_id', $detailedProduct->user_id)->orderBy('num_of_sale', 'desc'))->limit(6)->get() as $key => $top_product)
                                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                                        <div class="carousel-box">
                                            <a href="{{ route('product', $top_product->slug) }}" class="bg-white d-block text-reset rounded p-2 hov-shadow-md mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="top-10-img text-center border rounded">
                                                        <img
                                                            class="img lazyload rounded"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            data-src="{{ uploaded_asset($top_product->thumbnail_img) }}"
                                                            alt="{{ $top_product->getTranslation('name') }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                        >
                                                    </div>
                                                    <div class="text-left">
                                                        <h3 class="top-10-text">
                                                            <span class="text-truncate-2 pl-3 fs-18 fw-600 text-left">{{ $top_product->getTranslation('name') }}</span>
                                                            <div class="rating rating-sm mt-1 pl-3 top-10-selling-rating">
                                                                {{ renderStarRating($top_product->rating) }}
                                                            </div>
                                                            <div class="pl-3 top-10-selling-amount">
                                                                @if(home_base_price($top_product) != home_discounted_base_price($top_product))
                                                                    <del class="fw-600 opacity-50 mr-1 text-muted">{{ home_base_price($top_product) }}</del>
                                                                @endif
                                                                <span class="fw-700 text-primary">{{ home_discounted_base_price($top_product) }}</span>
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
        </div>
    </section>

@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title" value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login')}}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                @if (addon_is_activated('otp_system'))
                                    <input type="text" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone')}}" name="email" id="email">
                                @else
                                    <input type="email" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                @endif
                                @if (addon_is_activated('otp_system'))
                                    <span class="opacity-60">{{  translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg" placeholder="{{ translate('Password')}}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="plx-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{  translate('Remember Me') }}</span>
                                        <span class="plx-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}" class="text-reset opacity-60 fs-14">{{ translate('Forgot password?')}}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary btn-block fw-600">{{  translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?')}}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now')}}</a>
                        </div>
                        @if(get_setting('google_login') == 1 ||
                            get_setting('facebook_login') == 1 ||
                            get_setting('twitter_login') == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With')}}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (get_setting('facebook_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(get_setting('google_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('twitter_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
    	});

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                PLX.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                PLX.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
        }
        function show_chat_modal(){
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

    </script>
@endsection
