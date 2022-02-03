@extends('frontend.layouts.app')

@section('content')
<section class="pt-3 mb-3">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="section-title-main fw-600 mb-lg-4 mb-md-3 mb-sm-2">{{ translate('All Categories') }}</h1>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('categories.all') }}">"{{ translate('All Categories') }}"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="mb-4">
    <div class="container">
        @foreach ($categories as $key => $category)
            <div class="bg-white global-section-area-bottom">
                <div class="d-flex align-items-baseline border-bottom mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                    <a href="{{ route('products.category', $category->slug) }}">
                        <h3 class="section-title-main fw-600 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{  $category->getTranslation('name') }}</span>
                        </h3>
                    </a>
                </div>

                <div class="pt-lg-3 pt-md-2 pt-sm-1 pt-3">
                    <div class="row">
                    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 text-left">
                        <h6 class="mb-3"><a class="text-reset text-hover-base fw-600 fs-16" href="{{ route('products.category', \App\Models\Category::find($first_level_id)->slug) }}">{{ \App\Models\Category::find($first_level_id)->getTranslation('name') }}</a></h6>
                        <ul class="mb-3 list-unstyled pl-3">
                            @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
                            <li class="mb-2">
                                <a class="text-reset fw-500 fs-14 text-hover-base" href="{{ route('products.category', \App\Models\Category::find($second_level_id)->slug) }}" >{{ \App\Models\Category::find($second_level_id)->getTranslation('name') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
