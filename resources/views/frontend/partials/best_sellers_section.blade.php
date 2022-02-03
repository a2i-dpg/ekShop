@php
    $best_selers = Cache::remember('best_selers', 86400, function () {
        return \App\Models\Seller::where('verification_status', 1)->orderBy('num_of_sale', 'desc')->take(20)->get();
    });
@endphp

@if (get_setting('vendor_system_activation') == 1)
    <section class="best-seller-area">
        <div class="container">
            <div class="bg-white">
                <div class="d-flex align-items-baseline mb-lg-3 mb-md-2 mb-sm-1 mb-1">
                    <h3 class="section-title-main fw-600 mb-0">
                        <span class="d-inline-block">{{ translate('Best Sellers')}}</span>
                    </h3>
                    <a href="{{ route('sellers') }}" class="ml-auto mr-0 bg-white text-primary fs-16 fw-500">{{ translate('View All') }} <i class="la la-angle-right text-primary"></i></a>
                </div>
                <div class="plx-carousel gutters-10 half-outside-arrow" data-items="4" data-lg-items="3"  data-md-items="2" data-sm-items="2" data-xs-items="2" data-xxs-items="1" data-rows="1">
                    @foreach ($best_selers as $key => $seller)
                        @if ($seller->user != null)
                            <div class="carousel-box pb-2">
                                <div class="single-best-seller-area hov-shadow-md mt-3 has-transition">
                                    <div class="best-seller-img">
                                        <a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="d-block p-3">
                                            <img
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="@if ($seller->user->shop->logo !== null) {{ uploaded_asset($seller->user->shop->logo) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                                                alt="{{ $seller->user->shop->name }}"
                                                class="img-fluid lazyload"
                                            >
                                        </a>
                                    </div>
                                    <div class="best-seller-body">
                                        <div class="text-center">
                                            <h2 class="top-10-seller-name">
                                                <a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="text-reset">{{ $seller->user->shop->name }}</a>
                                            </h2>
                                            <div class="rating rating-sm mb-4 top-10-selling-rating">
                                                {{ renderStarRating($seller->rating) }}
                                            </div>
                                            <a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="btn btn-primary text-white text-nowrap border-primary btn-sm text-center fs-16">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.00007 6H19.0001C19.5501 6 20.0001 5.55 20.0001 5C20.0001 4.45 19.5501 4 19.0001 4H5.00007C4.45007 4 4.00007 4.45 4.00007 5C4.00007 5.55 4.45007 6 5.00007 6ZM20.1601 7.8C20.0701 7.34 19.6601 7 19.1801 7H4.82007C4.34007 7 3.93007 7.34 3.84007 7.8L2.84007 12.8C2.72007 13.42 3.19007 14 3.82007 14H4.00007V19C4.00007 19.55 4.45007 20 5.00007 20H13.0001C13.5501 20 14.0001 19.55 14.0001 19V14H18.0001V19C18.0001 19.55 18.4501 20 19.0001 20C19.5501 20 20.0001 19.55 20.0001 19V14H20.1801C20.8101 14 21.2801 13.42 21.1601 12.8L20.1601 7.8ZM12.0001 18H6.00007V14H12.0001V18Z" fill="white"/>
                                                </svg> {{ translate('Visit Store') }}
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
    </section>
@endif
