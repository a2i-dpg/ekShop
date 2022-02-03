@extends('frontend.layouts.app')

@section('content')

<section class="pt-3 mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <div class="section-title-main fw-600 mb-lg-3 mb-md-2 mb-sm-1 mb-1">{{ translate('All Brands') }}</div>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('brands.all') }}">"{{ translate('All Brands') }}"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="global-section-area-bottom-35">
    <div class="container">
        <div class="bg-white">
            <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gutters-10">
                @foreach (\App\Models\Brand::all() as $brand)
                    <div class="col text-center">
                        <div class="all-brand-category-outer">
                            <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-3 mb-3 border border-light rounded-10 hov-shadow-md">
                                <div class="all-brand-category">
                                    <img src="{{ uploaded_asset($brand->logo) }}" class="lazyload mx-auto" alt="{{ $brand->getTranslation('name') }}">
                                </div>
                            </a>
                            <div class="all-brand-category-name">
                                <span>{{ $brand->getTranslation('name') }}</span>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
