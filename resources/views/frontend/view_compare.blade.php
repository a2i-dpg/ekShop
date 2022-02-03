@extends('frontend.layouts.app')

@section('content')

<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="section-title-main fw-600 mb-lg-3 mb-md-2 mb-sm-1 mb-1">{{ translate('Compare')}}</h1>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('compare.reset') }}">"{{ translate('Compare')}}"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="global-section-area-bottom">
    <div class="container text-left">
        <div class="bg-white">
            <div class="pt-3 d-flex justify-content-between align-items-center mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                <div class="section-title-main">{{ translate('Comparison')}}</div>
                <a href="{{ route('compare.reset') }}" style="text-decoration: none;" class="btn btn-action-button btn-md fw-500">{{ translate('Reset Compare List')}}</a>
            </div>
            @if(Session::has('compare'))
                @if(count(Session::get('compare')) > 0)
                    <div class="py-3">
                        <table class="table table-responsive table-bordered mb-0 rounded-10" >
                            <thead>
                                <tr>
                                    <th scope="col" style="width:16%" class="fw-600 fs-16">
                                        {{ translate('Name')}}
                                    </th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <th scope="col" style="width:28%" class="fw-600 fs-16">
                                            <a class="text-reset fs-15" href="{{ route('product', \App\Models\Product::find($item)->slug) }}">{{ \App\Models\Product::find($item)->getTranslation('name') }}</a>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" class="fw-600 fs-16">{{ translate('Image')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <td>
                                            <img loading="lazy" src="{{ uploaded_asset(\App\Models\Product::find($item)->thumbnail_img) }}" alt="{{ translate('Product Image') }}" class="img-fluid py-4">
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row" class="fw-600 fs-16">{{ translate('Price')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        @php
                                            $product = \App\Models\Product::find($item);
                                        @endphp
                                        <td class="fs-16">
                                            @if(home_base_price($product) != home_discounted_base_price($product))
                                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
                                            @endif
                                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row" class="fw-600 fs-16">{{ translate('Brand')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <td class="fw-400 fs-16">
                                            @if (\App\Models\Product::find($item)->brand != null)
                                                {{ \App\Models\Product::find($item)->brand->getTranslation('name') }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row" class="fw-600 fs-16">{{ translate('Sub Category')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <td>
                                            @if (\App\Models\Product::find($item)->subsubcategory != null)
                                                {{ \App\Models\Product::find($item)->subsubcategory->getTranslation('name') }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row" class="fw-600 fs-16"></th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <td class="text-center py-4">
                                            <button type="button" class="btn btn-primary px-5 fw-600 text-nowrap" onclick="showAddToCartModal({{ $item }})">
                                                {{ translate('Add to cart')}}
                                            </button>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="text-center p-4">
                    <p class="fs-17">{{ translate('Your comparison list is empty')}}</p>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
