@if(get_setting('home_categories') != null)
    @php $home_categories = json_decode(get_setting('home_categories')); @endphp
    @foreach ($home_categories as $key => $value)
        @php $category = \App\Models\Category::find($value); @endphp
        <section class="home-category-area">
            <div class="container">
                <div class="bg-white">
                    <div class="d-flex align-items-baseline mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                        <h3 class="section-title-main fw-600 mb-0">
                            <span class="d-inline-block">{{ $category->getTranslation('name') }}</span>
                        </h3>
                        <a href="{{ route('products.category', $category->slug) }}" class="ml-auto mr-0 bg-white text-primary fs-16 fw-500">{{ translate('View All') }} <i class="la la-angle-right text-primary"></i></a>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-4 custom-d-sm-none">
                            <div class="home-category-banner-area mt-3">
                                <div class="home-category-banner-inner">
                                    <img
                                        class="img lazyload"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($category->banner) }}"
                                        alt="{{ $category->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                            <div class="plx-carousel gutters-10 half-outside-arrow" data-items="4" data-xl-items="4" data-lg-items="3"  data-md-items="2" data-sm-items="2" data-xs-items="2" data-xxs-items="1" data-arrows='true'>
                                @foreach (get_cached_products($category->id) as $key => $product)
                                    <div class="carousel-box">
                                        @include('frontend.partials.product_box_1',['product' => $product])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif

