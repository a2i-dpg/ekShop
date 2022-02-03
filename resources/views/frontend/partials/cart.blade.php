@php
if(auth()->user() != null) {
    $user_id = Auth::user()->id;
    $cart = \App\Models\Cart::where('user_id', $user_id)->get();
} else {
    $temp_user_id = Session()->get('temp_user_id');
    if($temp_user_id) {
        $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
    }
}

@endphp
<a href="javascript:void(0)" class="d-flex align-items-center text-reset h-100" data-toggle="dropdown" data-display="static">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="#3D3D3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="#3D3D3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="#3D3D3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span class="flex-grow-1 ml-1 position-relative">
        @if(isset($cart) && count($cart) > 0)
            <span class="badge badge-primary badge-inline badge-pill cart-count mobile-header-compare-custom">
                {{ count($cart)}}
            </span>
        @else
            <span class="badge badge-primary badge-inline badge-pill cart-count mobile-header-compare-custom">0</span>
        @endif
        <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Cart')}}</span>
    </span>
</a>
<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg p-0 stop-propagation">

    @if(isset($cart) && count($cart) > 0)
        <div class="p-3 fs-15 fw-600 p-3 border-bottom">
            {{translate('Cart Items')}}
        </div>
        <ul class="h-250px overflow-auto c-scrollbar-light list-group list-group-flush">
            @php
                $total = 0;
            @endphp
            @foreach($cart as $key => $cartItem)
                @php
                    $product = \App\Models\Product::find($cartItem['product_id']);
                    $total = $total + $cartItem['price'] * $cartItem['quantity'];
                @endphp
                @if ($product != null)
                    <li class="list-group-item">
                        <span class="d-flex align-items-center">
                            <a href="{{ route('product', $product->slug) }}" class="text-reset d-flex align-items-center flex-grow-1">
                                <img
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                    class="img-fit lazyload size-60px rounded"
                                    alt="{{  $product->getTranslation('name')  }}"
                                >
                                <span class="minw-0 pl-2 flex-grow-1">
                                    <span class="fw-600 mb-1 text-truncate-2">
                                            {{  $product->getTranslation('name')  }}
                                    </span>
                                    <span class="">{{ $cartItem['quantity'] }}x</span>
                                    <span class="">{{ single_price($cartItem['price']) }}</span>
                                </span>
                            </a>
                            <span class="">
                                <button onclick="removeFromCart({{ $cartItem['id'] }})" class="btn btn-sm btn-icon stop-propagation">
                                    <i class="la la-close"></i>
                                </button>
                            </span>
                        </span>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between">
            <span class="opacity-60">{{translate('Subtotal')}}</span>
            <span class="fw-600">{{ single_price($total) }}</span>
        </div>
        <div class="px-3 py-2 text-center border-top">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a href="{{ route('cart') }}" class="btn btn-action-button btn-md fs-16">
                        {{translate('View cart')}}
                    </a>
                </li>
                @if (Auth::check())
                <li class="list-inline-item">
                    <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary btn-sm fs-16">
                        {{translate('Checkout')}}
                    </a>
                </li>
                @endif
            </ul>
        </div>
    @else
        <div class="text-center p-3">
            <i class="las la-frown la-3x opacity-60 mb-3"></i>
            <h3 class="h6 fw-700">{{translate('Your Cart is empty')}}</h3>
        </div>
    @endif

</div>
