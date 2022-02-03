@extends('frontend.layouts.app')

@section('content')

<section class="pt-3 mb-3">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h3 class="fw-600 section-title-main mb-lg-3 mb-md-2 mb-sm-1 mb-1">{{ translate('Flash Deals')}}</h3>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">
                            {{ translate('Home')}}
                        </a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('flash-deals') }}">
                            "{{ translate('Flash Deals') }}"
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="banner-poster-area">
    <div class="container">
        <div class="row row-cols-1 row-cols-lg-2 gutters-10">
            @foreach($all_flash_deals as $single)
            <div class="col">
                <div class="bg-white rounded shadow-sm mb-3">
                    <a href="{{ route('flash-deal-details', $single->slug) }}" class="d-block text-reset banner-poster-img">
                        <img
                            src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                            data-src="{{ uploaded_asset($single->banner) }}"
                            alt="{{ $single->title }}"
                            class="img-fluid lazyload rounded w-100">
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
@endsection
