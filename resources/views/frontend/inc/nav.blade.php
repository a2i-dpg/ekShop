@if(get_setting('topbar_banner') != null)
<div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner" data-value="removed">
    <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset">
        <img src="{{ uploaded_asset(get_setting('topbar_banner')) }}" class="w-100 mw-100 h-50px h-lg-auto img-fit">
    </a>
    <button class="btn text-white absolute-top-right set-session" data-key="top-banner" data-value="removed" data-toggle="remove-parent" data-parent=".top-banner">
        <i class="la la-close la-2x"></i>
    </button>
</div>
@endif
<!-- Top Bar -->
<div class="top-navbar bg-white border-bottom border-soft-secondary z-1035">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center custom-header-top-res-mobile">
            <div class="help-content">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    <li class="list-inline-item border-left-0 pr-3 pl-0">
                        <a href="javascript:void(0)" class="text-reset d-inline-block opacity-60 py-2 text-wrap"><span class="text-nowrap">{{ translate('Need help? Call Us:')}}</span> <span class="text-nowrap">{{ get_setting('contact_phone') }}</span></a>
                    </li>
                </ul>
            </div>

            <div class="panel-content text-right d-sm-block">
                <ul class="list-inline mb-0 h-100 d-flex justify-content-end align-items-center">
                    @auth
                        @if(isAdmin())
                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                                <a href="{{ route('admin.dashboard') }}" class="text-reset d-inline-block opacity-60 py-0 text-nowrap">
                                    <span class="d-none d-sm-block"> {{ translate('My Panel')}}</span>
                                    <span class="d-block d-sm-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.9976 14.4498C8.19283 14.4498 6.35927 13.2224 5.28917 11.5979C0.155195 11.5979 0 20 0 20H19.994C19.994 20 20.397 11.5607 14.6234 11.5607C13.5546 13.2052 11.8024 14.4498 9.9976 14.4498V14.4498Z" fill="#92278F"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2973 4.37736C14.2973 6.79474 12.3711 11.4173 9.99308 11.4173C7.61884 11.4173 5.69141 6.7933 5.69141 4.37736C5.69141 1.96143 7.61758 0 9.99308 0C12.3711 0.00143379 14.2973 1.96286 14.2973 4.37736V4.37736Z" fill="#92278F"/>
                                        </svg>
                                    </span>
                                </a>
                            </li>
                        @else
                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0 dropdown">
                            <a class="dropdown-toggle no-arrow text-reset" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="">
                                    <span class="position-relative d-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23" viewBox="0 0 20 23" fill="none">
                                            <path d="M16.6669 7.33329C16.6669 5.56518 15.9645 3.86949 14.7143 2.61925C13.464 1.369 11.7684 0.666626 10.0002 0.666626C8.23213 0.666626 6.53644 1.369 5.2862 2.61925C4.03596 3.86949 3.33358 5.56518 3.33358 7.33329C3.33358 15.1111 0.000244141 17.3333 0.000244141 17.3333H20.0002C20.0002 17.3333 16.6669 15.1111 16.6669 7.33329Z" fill="#92278F"/>
                                            <path d="M11.9225 21.7777C11.7271 22.1145 11.4467 22.394 11.1094 22.5883C10.772 22.7826 10.3896 22.8849 10.0002 22.8849C9.61093 22.8849 9.22846 22.7826 8.8911 22.5883C8.55375 22.394 8.27337 22.1145 8.07802 21.7777" fill="#92278F"/>
                                        </svg>
                                        @if(count(Auth::user()->unreadNotifications) > 0)
                                            <span class="badge badge-sm badge-circle badge-primary position-absolute absolute-top-right"></span>
                                        @endif
                                    </span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0">
                                <div class="p-3 bg-light border-bottom">
                                    <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                                </div>
                                <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                                    <ul class="list-group list-group-flush" >
                                        @forelse(Auth::user()->unreadNotifications as $notification)
                                            <li class="list-group-item">
                                                @if($notification->type == 'App\Notifications\OrderNotification')
                                                    @if(Auth::user()->user_type == 'customer')
                                                    <a href="javascript:void(0)" onclick="show_purchase_history_details({{ $notification->data['order_id'] }})" class="text-reset">
                                                        <span class="ml-2">
                                                            {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                        </span>
                                                    </a>
                                                    @elseif (Auth::user()->user_type == 'seller')
                                                        @if(Auth::user()->id == $notification->data['user_id'])
                                                            <a href="javascript:void(0)" onclick="show_purchase_history_details({{ $notification->data['order_id'] }})" class="text-reset">
                                                                <span class="ml-2">
                                                                    {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                                </span>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)" onclick="show_order_details({{ $notification->data['order_id'] }})" class="text-reset">
                                                                <span class="ml-2">
                                                                    {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                                </span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </li>
                                        @empty
                                            <li class="list-group-item">
                                                <div class="py-4 text-center fs-16">
                                                    {{ translate('No notification found') }}
                                                </div>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="text-center border-top">
                                    <a href="{{ route('all-notifications') }}" class="text-reset d-block py-2">
                                        {{translate('View All Notifications')}}
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                            <a href="{{ route('dashboard') }}" class="text-reset d-inline-block py-0 custom-res-profile-web text-nowrap">
                                <span class="d-none d-sm-block"> {{ translate('My Panel')}}</span>
                                <span class="d-block d-sm-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.9976 14.4498C8.19283 14.4498 6.35927 13.2224 5.28917 11.5979C0.155195 11.5979 0 20 0 20H19.994C19.994 20 20.397 11.5607 14.6234 11.5607C13.5546 13.2052 11.8024 14.4498 9.9976 14.4498V14.4498Z" fill="#92278F"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2973 4.37736C14.2973 6.79474 12.3711 11.4173 9.99308 11.4173C7.61884 11.4173 5.69141 6.7933 5.69141 4.37736C5.69141 1.96143 7.61758 0 9.99308 0C12.3711 0.00143379 14.2973 1.96286 14.2973 4.37736V4.37736Z" fill="#92278F"/>
                                    </svg>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="text-reset d-inline-block py-0 custom-res-profile-mobile text-nowrap" data-toggle="class-toggle" data-backdrop="static" data-target=".plx-mobile-side-nav" data-same=".mobile-side-nav-thumb">
                                <span class="d-none d-sm-block"> {{ translate('My Panel')}}</span>
                                <span class="d-block d-sm-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.9976 14.4498C8.19283 14.4498 6.35927 13.2224 5.28917 11.5979C0.155195 11.5979 0 20 0 20H19.994C19.994 20 20.397 11.5607 14.6234 11.5607C13.5546 13.2052 11.8024 14.4498 9.9976 14.4498V14.4498Z" fill="#92278F"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2973 4.37736C14.2973 6.79474 12.3711 11.4173 9.99308 11.4173C7.61884 11.4173 5.69141 6.7933 5.69141 4.37736C5.69141 1.96143 7.61758 0 9.99308 0C12.3711 0.00143379 14.2973 1.96286 14.2973 4.37736V4.37736Z" fill="#92278F"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        @endif
                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                            <a href="{{ route('logout') }}" class="text-reset d-inline-block py-0" id="keycloak_logout">
                                <span class="d-none d-sm-block">{{ translate('Logout')}}</span>
                                <span class="d-block d-sm-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M11.667 9.16663H16.667V2.49996C16.667 2.27895 16.5792 2.06698 16.4229 1.9107C16.2666 1.75442 16.0547 1.66663 15.8337 1.66663H4.16699C3.94598 1.66663 3.73402 1.75442 3.57774 1.9107C3.42146 2.06698 3.33366 2.27895 3.33366 2.49996V17.5C3.33366 17.721 3.42146 17.9329 3.57774 18.0892C3.73402 18.2455 3.94598 18.3333 4.16699 18.3333H15.8337C16.0547 18.3333 16.2666 18.2455 16.4229 18.0892C16.5792 17.9329 16.667 17.721 16.667 17.5V10.8333H11.667V13.3333L7.50033 9.99996L11.667 6.66663V9.16663Z" fill="#92278F"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    @else
                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                            <a href="{{ route('user.login') }}" class="text-reset d-inline-block py-0">
                                <span class="d-none d-sm-block">{{ translate('Login')}}</span>
                                <span class="d-block d-sm-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M8.33301 9.16663H3.33301V2.49996C3.33301 2.27895 3.42081 2.06698 3.57709 1.9107C3.73337 1.75442 3.94533 1.66663 4.16634 1.66663H15.833C16.054 1.66663 16.266 1.75442 16.4223 1.9107C16.5785 2.06698 16.6663 2.27895 16.6663 2.49996V17.5C16.6663 17.721 16.5785 17.9329 16.4223 18.0892C16.266 18.2455 16.054 18.3333 15.833 18.3333H4.16634C3.94533 18.3333 3.73337 18.2455 3.57709 18.0892C3.42081 17.9329 3.33301 17.721 3.33301 17.5V10.8333H8.33301V13.3333L12.4997 9.99996L8.33301 6.66663V9.16663Z" fill="#92278F"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                            <a href="{{ route('user.registration') }}" class="text-reset d-inline-block py-0">
                                <span class="d-none d-sm-block">{{ translate('Registration')}}</span>
                                <span class="d-block d-sm-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M18.3338 3.55554L16.2782 1.49998C16.1015 1.33153 15.8668 1.23755 15.6227 1.23755C15.3785 1.23755 15.1438 1.33153 14.9671 1.49998L13.1393 3.33332H3.33377C3.03908 3.33332 2.75647 3.45038 2.54809 3.65875C2.33972 3.86713 2.22266 4.14974 2.22266 4.44443V16.6667C2.22266 16.9613 2.33972 17.244 2.54809 17.4523C2.75647 17.6607 3.03908 17.7778 3.33377 17.7778H15.556C15.8507 17.7778 16.1333 17.6607 16.3417 17.4523C16.55 17.244 16.6671 16.9613 16.6671 16.6667V6.53332L18.3338 4.86665C18.5075 4.6927 18.605 4.45692 18.605 4.21109C18.605 3.96527 18.5075 3.72949 18.3338 3.55554V3.55554ZM10.4615 11.1833L8.13377 11.7L8.68932 9.39443L13.9949 4.07776L15.7893 5.8722L10.4615 11.1833ZM16.3893 5.23887L14.5949 3.44443L15.6227 2.41665L17.4171 4.21109L16.3893 5.23887Z" fill="#92278F"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    @endauth
                    @if(get_setting('show_language_switcher') == 'on')
                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0 d-none d-sm-block dropdown" id="lang-change">
                            @php
                                if(Session::has('locale')){
                                    $locale = Session::get('locale', Config::get('app.locale'));
                                }
                                else{
                                    $locale = 'en';
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-0" data-toggle="dropdown" data-display="static">
                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-2 lazyload" alt="{{ \App\Models\Language::where('code', $locale)->first()->name }}" height="11">
                                <span class="opacity-60">{{ \App\Models\Language::where('code', $locale)->first()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left">
                                @foreach (\App\Models\Language::all() as $key => $language)
                                    <li>
                                        <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
                                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                            <span class="language">{{ $language->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    @if(get_setting('show_currency_switcher') == 'on')
                        <li class="list-inline-item dropdown ml-auto ml-md-0 mr-0" id="currency-change">
                            @php
                                if(Session::has('currency_code')){
                                    $currency_code = Session::get('currency_code');
                                }
                                else{
                                    $currency_code = \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-0 opacity-60" data-toggle="dropdown" data-display="static">
                                {{ \App\Models\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Models\Currency::where('code', $currency_code)->first()->symbol) }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                @foreach (\App\Models\Currency::where('status', 1)->get() as $key => $currency)
                                    <li>
                                        <a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Top Bar -->
<header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">
    <div class="position-relative logo-bar-area z-1">
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="col-auto col-xl-3 pl-0 pr-0 pr-sm-3 d-flex align-items-center">
                    <a class="d-block py-20px ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-40 h-sm-50px h-md-60px" height="40">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-40 h-sm-50px h-md-60px" height="40">
                        @endif
                    </a>
                </div>
                <div class="d-lg-none mobile-header-search-custom mr-0">
                    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
                        <i class="las la-search la-flip-horizontal la-2x"></i>
                    </a>
                </div>

                <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
                    <div class="position-relative flex-grow-1">
                        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                            <div class="d-flex position-relative align-items-center">
                                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                    <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                </div>
                                <div class="input-group search-input-group-header">
                                    <ul class="list-inline search-all-category">
                                        <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0" id="category-search">
                                            <a href="javascript:void(0)" class="dropdown-toggle text-reset header-search-all-category-select border-right" data-toggle="dropdown" data-display="static">
                                                All Category
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left header-search-all-category-feild">
                                                @foreach (\App\Models\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11) as $key => $category)
                                                    <li class="category-nav-element" data-id="{{ $category->id }}">
                                                        <a href="{{ route('products.category', $category->slug) }}" class="text-truncate text-reset py-2 px-3 d-block">
                                                            <img
                                                                class="cat-image lazyload mr-2 opacity-60"
                                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                data-src="{{ uploaded_asset($category->icon) }}"
                                                                width="16"
                                                                alt="{{ $category->getTranslation('name') }}"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            >
                                                            <span class="cat-name">{{ $category->getTranslation('name') }}</span>
                                                        </a>
                                                        @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                                                            <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4 d-none">
                                                                <div class="c-preloader text-center absolute-center">
                                                                    <i class="las la-spinner la-spin la-3x opacity-70"></i>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                    <input type="text" class="form-control search-all-category-input fs-16" id="search" name="keyword" @isset($query)
                                        value="{{ $query }}"
                                    @endisset placeholder="{{translate('Search Products..')}}" autocomplete="off">
                                    <div class="input-group-append d-none d-lg-block search-all-category-button">
                                        <button class="btn btn-sm" type="submit">
                                            <i class="la la-search la-flip-horizontal"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
                            <div class="search-preloader absolute-top-center">
                                <div class="dot-loader"><div></div><div></div><div></div></div>
                            </div>
                            <div class="search-nothing d-none p-3 text-center fs-16">

                            </div>
                            <div id="search-content" class="text-left">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-sm-block ml-2 ml-sm-3 mr-0">
                    <div class="" id="compare">
                        @include('frontend.partials.compare')
                    </div>
                </div>

                <div class="d-block ml-2 ml-sm-3 mr-0">
                    <div class="" id="wishlist">
                        @include('frontend.partials.wishlist')
                    </div>
                </div>

                <div class="d-sm-block align-self-stretch ml-2 ml-sm-3 mr-0" data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div>
            </div>
        </div>
        @if(Route::currentRouteName() != 'home')
        <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3" id="hover-category-menu">
            <div class="container">
                <div class="row gutters-10 position-relative">
                    <div class="col-lg-3 position-static">
                        @include('frontend.partials.category_menu')
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @if ( get_setting('header_menu_labels') !=  null )
        <div class="bg-white border-top border-gray-200 py-3">
            <div class="container position-relative">
                <div class="input-group text-left menu-all-category-area">
                    <ul class="list-inline ">
                        <li class="list-inline-item dropdown mb-0" id="category-menu">
                            <a href="javascript:void(0)" class="dropdown-toggle py-2" data-toggle="dropdown" data-display="static">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 12H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 6H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 18H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg> <div class="custom-d-sm-none">All Category</div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left all-category-dropdown-menu border-primary">
                                @foreach (\App\Models\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11) as $key => $category)
                                    <li class="category-nav-element border hover-shadow" data-id="{{ $category->id }}">
                                        <a href="{{ route('products.category', $category->slug) }}" class="text-truncate text-reset py-2 px-3 d-block">
                                            <img
                                                class="cat-image lazyload mr-2 opacity-60"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($category->icon) }}"
                                                width="16"
                                                alt="{{ $category->getTranslation('name') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                            >
                                            <span class="cat-name">{{ $category->getTranslation('name') }}</span>
                                        </a>
                                        @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                                            <div class="sub-cat-menu c-scrollbar-light rounded-10 loaded d-none">
                                                <div class="c-preloader text-center absolute-center">
                                                    <i class="las la-spinner la-spin la-3x opacity-70"></i>
                                                </div>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
                <ul class="list-inline mb-0 pl-0 mobile-hor-swipe header-main-menu-res">
                    @foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
                    <li class="list-inline-item mr-0">
                        <a href="{{ json_decode( get_setting('header_menu_links'), true)[$key] }}" class="text-3d3d3d fs-16 px-3 py-2 d-inline-block fw-600 hover-color-base">
                            {{ translate($value) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</header>
