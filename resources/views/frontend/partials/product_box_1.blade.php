<div class="plx-card-box border border-light rounded hov-shadow-md mt-3 has-transition bg-white category-product-single-area">
    @if(discount_in_percentage($product) > 0)
        <span class="badge-custom">{{ translate('OFF') }}<span class="box ml-1">&nbsp;{{discount_in_percentage($product)}}%</span></span>
    @endif
    <div class="position-relative">
        <a href="{{ route('product', $product->slug) }}" class="d-block">
            <div class="product-img-inner">
                <img
                    class="img-fit lazyload"
                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                    alt="{{  $product->getTranslation('name')  }}"
                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                >
            </div>
        </a>
        @if ($product->wholesale_product)
            <span class="absolute-bottom-left fs-11 text-white fw-600 px-2 lh-1-8" style="background-color: #455a64">
                {{ translate('Wholesale') }}
            </span>
        @endif
        <div class="absolute-top-right plx-p-hov-icon">
            <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                <i class="la la-heart-o"></i>
            </a>
            <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                <i class="las la-sync"></i>
        </div>
    </div>
    <div class="category-product-body-area text-center">
        <div class="category-product-amount">
            @if(home_base_price($product) != home_discounted_base_price($product))
                <del class="fw-600 opacity-50 mr-1 text-muted">{{ home_base_price($product) }}</del>
            @endif
            <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
        </div>
        <h3 class="mb-0 category-product-name">
            <a href="{{ route('product', $product->slug) }}" class="d-block">{{  $product->getTranslation('name')  }}</a>
        </h3>
        <div class="rating rating-sm mt-1 top-10-selling-rating text-center">
            By <span class="text-primary">{{ $product->added_by }}</span> {{ renderStarRating($product->rating) }}
        </div>
        <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" class="btn btn-primary text-white text-nowrap border-primary btn-sm text-center fs-16 mt-3">
            <i class="las la-shopping-cart"></i> {{ translate('Add to Cart') }}
        </a>
        @if (addon_is_activated('club_point'))
            <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                {{ translate('Club Point') }}:
                <span class="fw-700 float-right">{{ $product->earn_point }}</span>
            </div>
        @endif
    </div>
</div>
