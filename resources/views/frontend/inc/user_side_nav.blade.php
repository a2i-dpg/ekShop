<div class="plx-user-sidenav-wrap position-relative z-1">
    <div class="plx-user-sidenav rounded overflow-auto c-scrollbar-light pb-5 pb-xl-0">
        <div class="p-4 mb-3 position-relative d-flex align-items-center">
            <div class="profile-left">
                <span class="avatar custom-profile-avatar">
                @if (Auth::user()->avatar_original != null)
                        <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @else
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @endif
                </span>
            </div>
            <div class="profile-details-right">
                <h4 class="name mb-2">{{ Auth::user()->name }}</h4>
                @if(Auth::user()->phone != null)
                    <div class="profile-details-right-phone mb-2">{{ Auth::user()->phone }}</div>
                @else
                    <div class="profile-details-right-phone mb-2">{{ Auth::user()->email }}</div>
                @endif
                <a href="{{ route('profile') }}" class="profile-details-right-email {{ areActiveRoutes(['profile'])}}">
                    {{translate('Edit Profile')}}
                    <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" width="19" height="13" viewBox="0 0 19 13" fill="none">
                        <path d="M11.7206 10.6826C11.3153 11.0879 11.3153 11.745 11.7206 12.1504C12.1259 12.5557 12.783 12.5557 13.1883 12.1504L18.3777 6.96104C18.783 6.55572 18.783 5.89858 18.3777 5.49327L13.1883 0.303947C12.783 -0.10134 12.1259 -0.10134 11.7206 0.303947C11.3153 0.709234 11.3153 1.36641 11.7206 1.7717L15.1381 5.18928L0.98022 5.18928C0.438868 5.18928 5.7815e-05 5.65395 5.77649e-05 6.22715C5.77147e-05 6.80034 0.438868 7.26502 0.980219 7.26502L15.1381 7.26502L11.7206 10.6826Z" fill="#92278F"/>
                    </svg>
                </a>
            </div>
            <div class="verified-unverified-profile">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23 12L20.56 9.21L20.9 5.52L17.29 4.7L15.4 1.5L12 2.96L8.6 1.5L6.71 4.69L3.1 5.5L3.44 9.2L1 12L3.44 14.79L3.1 18.49L6.71 19.31L8.6 22.5L12 21.03L15.4 22.49L17.29 19.3L20.9 18.48L20.56 14.79L23 12ZM9.38 16.01L7 13.61C6.9073 13.5175 6.83375 13.4076 6.78357 13.2866C6.73339 13.1657 6.70756 13.036 6.70756 12.905C6.70756 12.774 6.73339 12.6443 6.78357 12.5234C6.83375 12.4024 6.9073 12.2925 7 12.2L7.07 12.13C7.46 11.74 8.1 11.74 8.49 12.13L10.1 13.75L15.25 8.59C15.64 8.2 16.28 8.2 16.67 8.59L16.74 8.66C17.13 9.05 17.13 9.68 16.74 10.07L10.82 16.01C10.41 16.4 9.78 16.4 9.38 16.01Z" fill="#009432"/>
                </svg>
            </div>
        </div>

        <div class="sidemnenu mb-3">
            <ul class="plx-side-nav-list" data-toggle="plx-side-menu">
                <li class="plx-side-nav-item mr-0">
                    <a href="{{ route('dashboard') }}" class="plx-side-nav-link {{ areActiveRoutes(['dashboard'])}}">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.24292 16.3062H13.6934V3.24316H3.24292V16.3062ZM3.24292 26.7567H13.6934V18.9188H3.24292V26.7567ZM16.306 26.7567H26.7564V13.6936H16.306V26.7567ZM16.306 3.24316V11.081H26.7564V3.24316H16.306Z" fill="#3D3D3D"/>
                        </svg>
                        <span class="plx-side-nav-text">{{ translate('Dashboard') }}</span>
                    </a>
                </li>

                @if(Auth::user()->user_type == 'delivery_boy')
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('assigned-deliveries') }}" class="plx-side-nav-link {{ areActiveRoutes(['completed-delivery'])}}">
                            <i class="las la-hourglass-half plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Assigned Delivery') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('pickup-deliveries') }}" class="plx-side-nav-link {{ areActiveRoutes(['completed-delivery'])}}">
                            <i class="las la-luggage-cart plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Pickup Delivery') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('on-the-way-deliveries') }}" class="plx-side-nav-link {{ areActiveRoutes(['completed-delivery'])}}">
                            <i class="las la-running plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('On The Way Delivery') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('completed-deliveries') }}" class="plx-side-nav-link {{ areActiveRoutes(['completed-delivery'])}}">
                            <i class="las la-check-circle plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Completed Delivery') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('pending-deliveries') }}" class="plx-side-nav-link {{ areActiveRoutes(['pending-delivery'])}}">
                            <i class="las la-clock plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Pending Delivery') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('cancelled-deliveries') }}" class="plx-side-nav-link {{ areActiveRoutes(['cancelled-delivery'])}}">
                            <i class="las la-times-circle plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Cancelled Delivery') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('cancel-request-list') }}" class="plx-side-nav-link {{ areActiveRoutes(['cancel-request-list'])}}">
                            <i class="las la-times-circle plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Request Cancelled Delivery') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('total-collection') }}" class="plx-side-nav-link {{ areActiveRoutes(['today-collection'])}}">
                            <i class="las la-comment-dollar plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Total Collections') }}
                            </span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('total-earnings') }}" class="plx-side-nav-link {{ areActiveRoutes(['total-earnings'])}}">
                            <i class="las la-comment-dollar plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">
                                {{ translate('Total Earnings') }}
                            </span>
                        </a>
                    </li>
                @else

                    @php
                        $delivery_viewed = App\Models\Order::where('user_id', Auth::user()->id)->where('delivery_viewed', 0)->get()->count();
                        $payment_status_viewed = App\Models\Order::where('user_id', Auth::user()->id)->where('payment_status_viewed', 0)->get()->count();
                    @endphp
                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('purchase_history.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['purchase_history.index'])}}">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25 27.5H5C4.66848 27.5 4.35054 27.3683 4.11612 27.1339C3.8817 26.8995 3.75 26.5815 3.75 26.25V3.75C3.75 3.41848 3.8817 3.10054 4.11612 2.86612C4.35054 2.6317 4.66848 2.5 5 2.5H25C25.3315 2.5 25.6495 2.6317 25.8839 2.86612C26.1183 3.10054 26.25 3.41848 26.25 3.75V26.25C26.25 26.5815 26.1183 26.8995 25.8839 27.1339C25.6495 27.3683 25.3315 27.5 25 27.5ZM10 8.75V11.25H20V8.75H10ZM10 13.75V16.25H20V13.75H10ZM10 18.75V21.25H16.25V18.75H10Z" fill="#3D3D3D"/>
                            </svg>
                            <span class="plx-side-nav-text">{{ translate('Purchase History') }}</span>
                            @if($delivery_viewed > 0 || $payment_status_viewed > 0)<span class="ml-2 badge badge-inline badge-success">{{ translate('New') }}</span>@endif
                        </a>
                    </li>

                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('digital_purchase_history.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['digital_purchase_history.index'])}}">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.2501 16.25V23.2312L18.5351 20.9462L20.3039 22.715L15.0001 28.0175L9.69636 22.715L11.4651 20.9462L13.7501 23.2312V16.25H16.2501ZM15.0001 2.5C17.1463 2.5001 19.2177 3.28889 20.8204 4.7164C22.423 6.1439 23.4452 8.11058 23.6926 10.2425C25.2479 10.6666 26.6048 11.6239 27.5259 12.9469C28.4471 14.2699 28.874 15.8746 28.7321 17.4805C28.5902 19.0864 27.8885 20.5913 26.7496 21.7323C25.6106 22.8732 24.107 23.5777 22.5014 23.7225L22.5001 21.25C22.5021 19.2839 21.732 17.3957 20.3555 15.9918C18.9791 14.5879 17.1065 13.7806 15.1408 13.7438C13.175 13.7069 11.2734 14.4434 9.84534 15.7947C8.41725 17.146 7.57686 19.004 7.50511 20.9687L7.50011 21.25V23.7225C5.89442 23.5779 4.39062 22.8736 3.25153 21.7327C2.11244 20.5919 1.41052 19.0869 1.26845 17.481C1.12639 15.8751 1.55321 14.2704 2.47432 12.9472C3.39543 11.6241 4.75225 10.6667 6.30761 10.2425C6.55474 8.11047 7.57687 6.14364 9.17959 4.71608C10.7823 3.28852 12.8538 2.49983 15.0001 2.5Z" fill="#3D3D3D"/>
                            </svg>
                            <span class="plx-side-nav-text">{{ translate('Downloads') }}</span>
                        </a>
                    </li>

                    @if (addon_is_activated('refund_request'))
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('customer_refund_request') }}" class="plx-side-nav-link {{ areActiveRoutes(['customer_refund_request'])}}">
                                <i class="las la-backward plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{ translate('Sent Refund Request') }}</span>
                            </a>
                        </li>
                    @endif

                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('wishlists.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['wishlists.index'])}}">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M26.1141 6.01478C25.4757 5.37604 24.7176 4.86934 23.8833 4.52364C23.049 4.17793 22.1547 4 21.2516 4C20.3485 4 19.4542 4.17793 18.6199 4.52364C17.7856 4.86934 17.0276 5.37604 16.3891 6.01478L15.0641 7.33978L13.7391 6.01478C12.4495 4.72517 10.7004 4.00067 8.87661 4.00067C7.05282 4.00067 5.30373 4.72517 4.01411 6.01478C2.7245 7.3044 2 9.05349 2 10.8773C2 12.7011 2.7245 14.4502 4.01411 15.7398L5.33911 17.0648L15.0641 26.7898L24.7891 17.0648L26.1141 15.7398C26.7529 15.1013 27.2596 14.3433 27.6053 13.509C27.951 12.6747 28.1289 11.7804 28.1289 10.8773C28.1289 9.97417 27.951 9.07991 27.6053 8.24559C27.2596 7.41126 26.7529 6.65323 26.1141 6.01478Z" fill="#3D3D3D"/>
                            </svg>
                            <span class="plx-side-nav-text">{{ translate('Wishlist') }}</span>
                        </a>
                    </li>

                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('compare') }}" class="plx-side-nav-link plx-side-nav-link-compare {{ areActiveRoutes(['compare'])}}">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.25 1.25L26.25 6.25L21.25 11.25" stroke="#3D3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3.75 13.75V11.25C3.75 9.92392 4.27678 8.65215 5.21447 7.71447C6.15215 6.77678 7.42392 6.25 8.75 6.25H26.25" stroke="#3D3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.75 28.75L3.75 23.75L8.75 18.75" stroke="#3D3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M26.25 16.25V18.75C26.25 20.0761 25.7232 21.3479 24.7855 22.2855C23.8479 23.2232 22.5761 23.75 21.25 23.75H3.75" stroke="#3D3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="plx-side-nav-text">{{ translate('Compare') }}</span>
                        </a>
                    </li>

                    @if(Auth::user()->user_type == 'seller')
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('seller.products') }}" class="plx-side-nav-link {{ areActiveRoutes(['seller.products', 'seller.products.upload', 'seller.products.edit'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.125 2.5H21.875C22.0691 2.5 22.2604 2.54518 22.434 2.63197C22.6076 2.71875 22.7586 2.84476 22.875 3L26.25 7.5V26.25C26.25 26.5815 26.1183 26.8995 25.8839 27.1339C25.6495 27.3683 25.3315 27.5 25 27.5H5C4.66848 27.5 4.35054 27.3683 4.11612 27.1339C3.8817 26.8995 3.75 26.5815 3.75 26.25V7.5L7.125 3C7.24143 2.84476 7.39241 2.71875 7.56598 2.63197C7.73955 2.54518 7.93094 2.5 8.125 2.5ZM23.125 7.5L21.25 5H8.75L6.875 7.5H23.125ZM11.25 12.5H8.75V15C8.75 16.6576 9.40848 18.2473 10.5806 19.4194C11.7527 20.5915 13.3424 21.25 15 21.25C16.6576 21.25 18.2473 20.5915 19.4194 19.4194C20.5915 18.2473 21.25 16.6576 21.25 15V12.5H18.75V15C18.75 15.9946 18.3549 16.9484 17.6517 17.6517C16.9484 18.3549 15.9946 18.75 15 18.75C14.0054 18.75 13.0516 18.3549 12.3483 17.6517C11.6451 16.9484 11.25 15.9946 11.25 15V12.5Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Products') }}</span>
                            </a>
                        </li>
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{route('product_bulk_upload.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['product_bulk_upload.index'])}}">
                                <svg width="36" height="28" viewBox="0 0 36 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.1014 7.91659H20.7681V4.99992H21.6014V8.33325C21.6014 8.44376 21.5575 8.54974 21.4794 8.62788C21.4012 8.70602 21.2952 8.74992 21.1847 8.74992H13.6847C13.5742 8.74992 13.4682 8.70602 13.3901 8.62788C13.312 8.54974 13.2681 8.44376 13.2681 8.33325V4.99992H14.1014V7.91659ZM18.2681 3.74992V6.24992H16.6014V3.74992H14.5181L17.4347 0.833252L20.3514 3.74992H18.2681Z" fill="#3D3D3D"/>
                                    <path d="M5.08703 10.3479H13.6957C13.8172 10.3479 13.9371 10.3762 14.0457 10.4305C14.1544 10.4849 14.2489 10.5637 14.3218 10.6609L16.4349 13.4783V25.2175C16.4349 25.425 16.3524 25.6241 16.2056 25.7709C16.0589 25.9176 15.8598 26.0001 15.6522 26.0001H3.13051C2.92295 26.0001 2.72389 25.9176 2.57712 25.7709C2.43035 25.6241 2.3479 25.425 2.3479 25.2175V13.4783L4.46094 10.6609C4.53384 10.5637 4.62837 10.4849 4.73704 10.4305C4.84571 10.3762 4.96553 10.3479 5.08703 10.3479ZM14.4783 13.4783L13.3044 11.9131H5.47834L4.30442 13.4783H14.4783ZM7.04355 16.6088H5.47834V18.174C5.47834 19.2118 5.8906 20.2071 6.62444 20.9409C7.35828 21.6748 8.35357 22.087 9.39138 22.087C10.4292 22.087 11.4245 21.6748 12.1583 20.9409C12.8922 20.2071 13.3044 19.2118 13.3044 18.174V16.6088H11.7392V18.174C11.7392 18.7967 11.4918 19.3938 11.0515 19.8342C10.6112 20.2745 10.0141 20.5218 9.39138 20.5218C8.7687 20.5218 8.17152 20.2745 7.73121 19.8342C7.29091 19.3938 7.04355 18.7967 7.04355 18.174V16.6088Z" fill="#3D3D3D"/>
                                    <path d="M21.3917 10.3479H30.0004C30.1219 10.3479 30.2417 10.3762 30.3504 10.4305C30.4591 10.4849 30.5536 10.5637 30.6265 10.6609L32.7395 13.4783V25.2175C32.7395 25.425 32.6571 25.6241 32.5103 25.7709C32.3636 25.9176 32.1645 26.0001 31.9569 26.0001H19.4352C19.2276 26.0001 19.0286 25.9176 18.8818 25.7709C18.735 25.6241 18.6526 25.425 18.6526 25.2175V13.4783L20.7656 10.6609C20.8385 10.5637 20.9331 10.4849 21.0417 10.4305C21.1504 10.3762 21.2702 10.3479 21.3917 10.3479ZM30.783 13.4783L29.6091 11.9131H21.783L20.6091 13.4783H30.783ZM23.3482 16.6088H21.783V18.174C21.783 19.2118 22.1953 20.2071 22.9291 20.9409C23.663 21.6748 24.6583 22.087 25.6961 22.087C26.7339 22.087 27.7292 21.6748 28.463 20.9409C29.1968 20.2071 29.6091 19.2118 29.6091 18.174V16.6088H28.0439V18.174C28.0439 18.7967 27.7965 19.3938 27.3562 19.8342C26.9159 20.2745 26.3187 20.5218 25.6961 20.5218C25.0734 20.5218 24.4762 20.2745 24.0359 19.8342C23.5956 19.3938 23.3482 18.7967 23.3482 18.174V16.6088Z" fill="#3D3D3D"/>
                                </svg>

                                <span class="plx-side-nav-text">{{ translate('Product Bulk Upload') }}</span>
                            </a>
                        </li>
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('seller.digitalproducts') }}" class="plx-side-nav-link {{ areActiveRoutes(['seller.digitalproducts', 'seller.digitalproducts.upload', 'seller.digitalproducts.edit'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.4785 0.0644531C18.8086 0.287109 17.2734 1.02539 16.0078 2.20312L15.5273 2.64844V7.99805V13.3418L15.9551 13.7461C16.7637 14.5137 17.7129 15.1172 18.6914 15.4863L19.0781 15.6328L19.3477 15.4922C19.5 15.416 19.8516 15.2812 20.1387 15.1992C20.5898 15.0586 20.7598 15.041 21.4746 15.0352C22.3711 15.0293 22.834 15.123 23.5723 15.457L23.9355 15.6211L24.4043 15.4395C26.6309 14.5605 28.3242 12.7676 29.0918 10.4707C29.3555 9.67969 29.4727 8.92383 29.4727 7.99805C29.4727 7.0957 29.3613 6.36328 29.1152 5.57812C28.2305 2.80078 25.8691 0.703125 23.0098 0.146484C22.4297 0.0292969 21.041 -0.0117188 20.4785 0.0644531ZM16.9922 7.99805V12.0117H16.4941H15.9961V7.99805V3.98438H16.4941H16.9922V7.99805ZM18.5156 7.23633V10.4883H18.0176H17.5195V7.23633V3.98438H18.0176H18.5156V7.23633ZM19.9805 7.23633V10.4883H19.4824H18.9844V7.23633V3.98438H19.4824H19.9805V7.23633ZM21.5039 7.99805V12.0117H21.0059H20.5078V7.99805V3.98438H21.0059H21.5039V7.99805ZM22.998 7.99805V11.9824H22.5H22.002L21.9844 8.05664C21.9785 5.89453 21.9844 4.0957 22.002 4.05469C22.0195 4.00195 22.1602 3.98438 22.5117 3.99609L22.998 4.01367V7.99805ZM24.4922 7.23633V10.4883H23.9941H23.4961V7.23633V3.98438H23.9941H24.4922V7.23633ZM26.0156 7.23633V10.4883H25.5176H25.0195V7.23633V3.98438H25.5176H26.0156V7.23633ZM27.4805 7.99805V12.0117H26.9824H26.4844V7.99805V3.98438H26.9824H27.4805V7.99805ZM18.5156 11.5137V12.0117H18.0176H17.5195V11.5137V11.0156H18.0176H18.5156V11.5137ZM19.9805 11.5137V12.0117H19.4824H18.9844V11.5137V11.0156H19.4824H19.9805V11.5137ZM24.4922 11.5137V12.0117H23.9941H23.4961V11.5137V11.0156H23.9941H24.4922V11.5137ZM26.0156 11.5137V12.0117H25.5176H25.0195V11.5137V11.0156H25.5176H26.0156V11.5137Z" fill="#3D3D3D"/>
                                    <path d="M1.52344 1.08398C1.16602 1.19531 0.861328 1.46484 0.679688 1.82812L0.527344 2.13281V8.58398V15.0352L0.673828 15.3281C0.761719 15.5039 1.06641 15.8672 1.48242 16.2773L2.15039 16.9395L2.37891 16.5527C2.79492 15.8379 3.55078 15.2754 4.3418 15.0879C4.89258 14.959 10.1074 14.959 10.6582 15.0879C11.4492 15.2754 12.2051 15.8379 12.6211 16.5527L12.8496 16.9395L13.5176 16.2773C13.9336 15.8672 14.2383 15.5039 14.3262 15.3281L14.4727 15.0352V8.58398V2.13281L14.3203 1.82812C14.1328 1.45312 13.834 1.19531 13.4531 1.08398C13.0312 0.955078 1.92773 0.960938 1.52344 1.08398ZM12.7441 2.55469C13.0078 2.66016 13.0078 2.61328 13.0078 7.99805C13.0078 13.3828 13.0078 13.3359 12.7441 13.4414C12.6152 13.4883 2.38477 13.4883 2.25586 13.4414C1.99219 13.3359 1.99219 13.3828 1.99219 7.99805C1.99219 3.63281 2.00391 2.90039 2.08008 2.75391C2.12695 2.66602 2.19727 2.57812 2.23828 2.56055C2.34961 2.51367 12.627 2.51367 12.7441 2.55469Z" fill="#3D3D3D"/>
                                    <path d="M2.98828 4.51172V5.50781H3.48633H3.98438V5.00977V4.51172H4.48242H4.98047V4.01367V3.51562H3.98438H2.98828V4.51172Z" fill="#3D3D3D"/>
                                    <path d="M10.0195 4.01367V4.51172H10.5176H11.0156V5.00977V5.50781H11.5137H12.0117V4.51172V3.51562H11.0156H10.0195V4.01367Z" fill="#3D3D3D"/>
                                    <path d="M4.01392 6.05273C3.99634 6.08789 3.99048 6.99609 3.99634 8.05664L4.01392 9.99023L4.50024 10.0078L4.98071 10.0254V7.99805V5.97656H4.51196C4.18384 5.97656 4.03149 6 4.01392 6.05273Z" fill="#3D3D3D"/>
                                    <path d="M5.50781 7.23633V8.49609H6.00586H6.50391V7.23633V5.97656H6.00586H5.50781V7.23633Z" fill="#3D3D3D"/>
                                    <path d="M7.01367 6.01172C6.99023 6.03516 6.97266 6.60352 6.97266 7.27734V8.49609H7.5H8.02734L8.01562 7.24805L7.99805 6.00586L7.5293 5.98828C7.26562 5.98242 7.03711 5.98828 7.01367 6.01172Z" fill="#3D3D3D"/>
                                    <path d="M8.49609 7.99805V10.0195H8.99414H9.49219V7.99805V5.97656H8.99414H8.49609V7.99805Z" fill="#3D3D3D"/>
                                    <path d="M10.0195 7.99805V10.0254L10.5059 10.0078L10.9863 9.99023V7.99805V6.00586L10.5059 5.98828L10.0195 5.9707V7.99805Z" fill="#3D3D3D"/>
                                    <path d="M5.50781 9.52148V10.0195H6.00586H6.50391V9.52148V9.02344H6.00586H5.50781V9.52148Z" fill="#3D3D3D"/>
                                    <path d="M6.98389 9.50391L7.00146 9.99023H7.49951H7.99756L8.01514 9.50391L8.03271 9.02344H7.49951H6.96631L6.98389 9.50391Z" fill="#3D3D3D"/>
                                    <path d="M2.98828 11.4844V12.4805H3.98438H4.98047V11.9824V11.4844H4.48242H3.98438V10.9863V10.4883H3.48633H2.98828V11.4844Z" fill="#3D3D3D"/>
                                    <path d="M11.0156 10.9863V11.4844H10.5176H10.0195V11.9824V12.4805H11.0156H12.0117V11.4844V10.4883H11.5137H11.0156V10.9863Z" fill="#3D3D3D"/>
                                    <path d="M4.55298 16.0605C4.11939 16.1602 3.49829 16.582 3.33423 16.8867C3.28149 16.9863 3.32837 16.9922 4.39478 16.9922H5.50806V16.4941V15.9961L5.14478 16.002C4.9397 16.0078 4.67603 16.0312 4.55298 16.0605Z" fill="#3D3D3D"/>
                                    <path d="M6.50391 16.4941V16.9922H7.5H8.49609V16.4941V15.9961H7.5H6.50391V16.4941Z" fill="#3D3D3D"/>
                                    <path d="M9.49219 16.4883V16.9922H10.6055C11.8711 16.9922 11.8535 16.998 11.3613 16.5527C10.9863 16.2129 10.5586 16.0488 9.98438 16.0078L9.49219 15.9785V16.4883Z" fill="#3D3D3D"/>
                                    <path d="M20.8066 16.0547C18.8379 16.4707 17.5195 18.0586 17.5195 20.0098C17.5195 21.123 17.8828 21.9785 18.6914 22.7988C19.0957 23.209 19.2832 23.3496 19.6875 23.5488C20.3555 23.8711 20.8242 23.9824 21.5039 23.9824C22.1777 23.9824 22.6582 23.8711 23.2969 23.5547C25.2246 22.6113 26.0332 20.209 25.084 18.2578C24.4219 16.8984 23.1563 16.0781 21.6504 16.0254C21.3281 16.0137 20.9473 16.0254 20.8066 16.0547ZM22.4297 20.7832L20.5078 22.7051L19.834 22.0313L19.1602 21.3574L19.5117 21.0059L19.8633 20.6543L20.1855 20.9766L20.5078 21.2988L22.0781 19.7285L23.6426 18.1641L23.9941 18.5156L24.3457 18.8672L22.4297 20.7832Z" fill="#3D3D3D"/>
                                    <path d="M2.51953 23.3145C2.51953 26.2441 2.53711 28.6875 2.55469 28.7402C2.66016 29.0039 2.64844 29.0039 7.5 29.0039C12.3516 29.0039 12.3398 29.0039 12.4453 28.7402C12.4629 28.6875 12.4805 26.2441 12.4805 23.3145V17.9883H7.5H2.51953V23.3145ZM5.50781 20.4785V20.9766H4.51172H3.51562V20.4785V19.9805H4.51172H5.50781V20.4785ZM8.49609 20.4785V20.9766H7.5H6.50391V20.4785V19.9805H7.5H8.49609V20.4785ZM11.4844 20.4785V20.9766H10.4883H9.49219V20.4785V19.9805H10.4883H11.4844V20.4785ZM5.50781 23.5254V24.0234H4.51172H3.51562V23.5254V23.0273H4.51172H5.50781V23.5254ZM8.49609 23.5254V24.0234H7.5H6.50391V23.5254V23.0273H7.5H8.49609V23.5254ZM11.4844 23.5254V24.0234H10.4883H9.49219V23.5254V23.0273H10.4883H11.4844V23.5254ZM5.50781 26.5137V27.0117H4.51172H3.51562V26.5137V26.0156H4.51172H5.50781V26.5137ZM8.49609 26.5137V27.0117H7.5H6.50391V26.5137V26.0156H7.5H8.49609V26.5137ZM11.4844 26.5137V27.0117H10.4883H9.49219V26.5137V26.0156H10.4883H11.4844V26.5137Z" fill="#3D3D3D"/>
                                    <path d="M15.1169 27.076C14.7185 27.2342 14.5251 27.5799 14.4841 28.2128C14.4255 29.1971 14.572 29.6249 15.0583 29.871C15.2986 29.994 15.3865 30.0057 16.0896 29.9881C16.8279 29.9706 16.863 29.9647 17.0681 29.8065C17.4079 29.5487 17.4841 29.3495 17.5076 28.6522C17.5193 28.3006 17.5017 27.9315 17.4665 27.7909C17.3845 27.4862 17.1443 27.1991 16.8923 27.0936C16.6697 26.994 15.3454 26.9881 15.1169 27.076Z" fill="#3D3D3D"/>
                                    <path d="M19.0547 27.1113C18.9492 27.1641 18.791 27.2988 18.7031 27.4102C18.5508 27.6094 18.5449 27.6504 18.5273 28.4414C18.5156 29.209 18.5215 29.2852 18.6445 29.502C18.8672 29.8887 19.1601 30 19.9922 30C20.7597 30 20.9648 29.9414 21.2226 29.6719C21.4629 29.4141 21.5039 29.2324 21.5039 28.4941C21.5039 27.6621 21.4043 27.3867 21.0117 27.1582C20.7773 27.0234 20.707 27.0117 20.0039 27.0117C19.4238 27.0117 19.2012 27.0352 19.0547 27.1113Z" fill="#3D3D3D"/>
                                    <path d="M23.0039 27.1465C22.8574 27.2285 22.7227 27.375 22.6348 27.5332C22.5176 27.7617 22.5 27.873 22.5 28.4824C22.5 29.2324 22.541 29.4141 22.7812 29.6719C23.0391 29.9414 23.2441 30 24.0059 30C24.8437 30 25.1133 29.9004 25.3477 29.4961C25.4941 29.25 25.4941 29.2148 25.4766 28.4297C25.459 27.6504 25.4531 27.6094 25.3008 27.4102C25.043 27.0703 24.8437 27.0117 23.9824 27.0117C23.3145 27.0117 23.209 27.0293 23.0039 27.1465Z" fill="#3D3D3D"/>
                                    <path d="M27.0999 27.0937C26.8655 27.1992 26.6312 27.4629 26.5491 27.709C26.4378 28.043 26.4671 29.1094 26.596 29.3848C26.8304 29.8887 27.0765 30 27.9788 30C28.7933 30 29.0569 29.9121 29.303 29.5723C29.4729 29.3379 29.4729 29.332 29.4729 28.5059C29.4729 27.7383 29.4612 27.6562 29.344 27.4805C29.0687 27.082 28.9632 27.041 28.0784 27.0293C27.4925 27.0176 27.2288 27.0352 27.0999 27.0937Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Digital Products') }}</span>
                            </a>
                        </li>
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('my_uploads.all') }}" class="plx-side-nav-link {{ areActiveRoutes(['my_uploads.new'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1_12998)">
                                        <g clip-path="url(#clip1_1_12998)">
                                            <path d="M7.27224 24.3182H25.4541V16.3636H27.7268V25.4545C27.7268 25.7559 27.6071 26.045 27.394 26.2581C27.1808 26.4712 26.8918 26.5909 26.5904 26.5909H6.13588C5.83449 26.5909 5.54545 26.4712 5.33234 26.2581C5.11924 26.045 4.99951 25.7559 4.99951 25.4545V16.3636H7.27224V24.3182ZM18.6359 12.9545V19.7727H14.0904V12.9545H8.4086L16.3631 5L24.3177 12.9545H18.6359Z" fill="#3D3D3D"/>
                                        </g>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1_12998">
                                            <rect width="30" height="30" fill="white"/>
                                        </clipPath>
                                        <clipPath id="clip1_1_12998">
                                            <rect width="27.2727" height="27.2727" fill="white" transform="translate(2.72729 2.72729)"/>
                                        </clipPath>
                                    </defs>
                                </svg>

                                <span class="plx-side-nav-text">{{ translate('Uploaded Files') }}</span>
                            </a>
                        </li>
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('seller.coupon.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['my_uploads.new'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.65625 6.09375C0.550781 6.11719 0.392578 6.19922 0.310547 6.27539C0.00585938 6.5625 0 6.60352 0 9.26367C0 11.6602 0.00585938 11.7363 0.123047 11.9531C0.292969 12.252 0.503906 12.3574 1.03711 12.4219C1.28906 12.4512 1.58203 12.5039 1.69336 12.5449C2.58984 12.8613 3.25195 13.6582 3.41602 14.6191C3.61523 15.7969 2.85938 17.0391 1.69336 17.4551C1.58203 17.4961 1.28906 17.5488 1.03711 17.5781C0.503906 17.6426 0.292969 17.748 0.123047 18.0527C0 18.2695 -0.00585938 18.3164 0.0117188 20.8242C0.0292969 23.291 0.0351562 23.373 0.152344 23.5312C0.216797 23.6191 0.345703 23.748 0.433594 23.8125C0.591797 23.9355 0.644531 23.9355 4.4707 23.9355H8.34961L8.37891 21.6094C8.4082 19.377 8.41406 19.2773 8.53125 19.1191C8.67773 18.9199 8.99414 18.75 9.22852 18.75C9.46289 18.75 9.7793 18.9199 9.92578 19.1191C10.043 19.2773 10.0488 19.377 10.0781 21.6094L10.1074 23.9355H19.7578H29.4082L29.5664 23.8125C29.6543 23.748 29.7832 23.6191 29.8477 23.5312C29.9648 23.373 29.9707 23.291 29.9883 20.8242C30.0059 18.3164 30 18.2695 29.877 18.0527C29.707 17.748 29.4961 17.6426 28.9629 17.5781C28.7109 17.5488 28.418 17.4961 28.3066 17.4551C27.1406 17.0391 26.3848 15.7969 26.584 14.6191C26.748 13.6582 27.4102 12.8613 28.3066 12.5449C28.418 12.5039 28.7109 12.4512 28.9629 12.4219C29.4961 12.3574 29.707 12.252 29.877 11.9473C30 11.7305 30.0059 11.6836 29.9883 9.17578C29.9707 6.70898 29.9648 6.62695 29.8477 6.46875C29.7832 6.38086 29.6543 6.25195 29.5664 6.1875L29.4082 6.06445H19.7578H10.1074L10.0781 8.39062C10.0488 10.623 10.043 10.7227 9.92578 10.8809C9.7793 11.0801 9.46289 11.25 9.22852 11.25C8.99414 11.25 8.67773 11.0801 8.53125 10.8809C8.41406 10.7227 8.4082 10.623 8.37891 8.39062L8.34961 6.06445L4.59961 6.05273C2.53711 6.05273 0.761719 6.07031 0.65625 6.09375ZM9.65625 13.1016C9.74414 13.1543 9.86719 13.2656 9.93164 13.3477C10.043 13.4941 10.0488 13.5996 10.0488 15C10.0488 16.4004 10.043 16.5059 9.93164 16.6523C9.75 16.8867 9.5332 16.9922 9.21094 16.9922C8.88281 16.9922 8.625 16.8281 8.4668 16.5176C8.33789 16.2773 8.33789 13.7227 8.4668 13.4824C8.625 13.1719 8.88281 13.0078 9.21094 13.0078C9.375 13.0078 9.57422 13.0488 9.65625 13.1016Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Coupon') }}</span>
                            </a>
                        </li>
                    @endif

                    @if(addon_is_activated('auction'))
                        <li class="plx-side-nav-item mr-0">
                            <a href="javascript:void(0);" class="plx-side-nav-link">
                                <i class="las la-gavel plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{ translate('Auction') }}</span>
                                <span class="plx-side-nav-arrow"></span>
                            </a>
                            <ul class="plx-side-nav-list level-2">
                                @if (Auth::user()->user_type == 'seller')
                                    <li class="plx-side-nav-item">
                                        <a href="{{ route('auction_products.seller.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['auction_products.seller.index','auction_products.create','auction_products.edit'])}}">
                                            <span class="plx-side-nav-text">{{ translate('All Auction Products') }}</span>
                                        </a>
                                    </li>
                                    <li class="plx-side-nav-item">
                                        <a href="{{ route('auction_products_orders.seller') }}" class="plx-side-nav-link {{ areActiveRoutes(['auction_products_orders.seller'])}}">
                                            <span class="plx-side-nav-text">{{ translate('Auction Product Orders') }}</span>
                                        </a>
                                    </li>
                                @endif
                                <li class="plx-side-nav-item">
                                    <a href="{{ route('auction_product_bids.index') }}" class="plx-side-nav-link">
                                        <span class="plx-side-nav-text">{{ translate('Bidded Products') }}</span>
                                    </a>
                                </li>
                                <li class="plx-side-nav-item">
                                    <a href="{{ route('auction_product.purchase_history') }}" class="plx-side-nav-link">
                                        <span class="plx-side-nav-text">{{ translate('Purchase History') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(Auth::user()->user_type == 'seller')
                        @if (addon_is_activated('pos_system'))
                            @if (\App\Models\BusinessSetting::where('type', 'pos_activation_for_seller')->first() != null && get_setting('pos_activation_for_seller') != 0)
                                <li class="plx-side-nav-item mr-0">
                                    <a href="{{ route('poin-of-sales.seller_index') }}" class="plx-side-nav-link {{ areActiveRoutes(['poin-of-sales.seller_index'])}}">
                                        <i class="las la-fax plx-side-nav-icon"></i>
                                        <span class="plx-side-nav-text">{{ translate('POS Manager') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('orders.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['orders.index'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.3333 1.66675H6.66667C6.22464 1.66675 5.80072 1.84234 5.48816 2.1549C5.17559 2.46746 5 2.89139 5 3.33341V26.6667C5 27.1088 5.17559 27.5327 5.48816 27.8453C5.80072 28.1578 6.22464 28.3334 6.66667 28.3334H23.3333C23.7754 28.3334 24.1993 28.1578 24.5118 27.8453C24.8244 27.5327 25 27.1088 25 26.6667V3.33341C25 2.89139 24.8244 2.46746 24.5118 2.1549C24.1993 1.84234 23.7754 1.66675 23.3333 1.66675ZM10.8333 21.6667H9.16667V20.0001H10.8333V21.6667ZM10.8333 18.3334H9.16667V16.6667H10.8333V18.3334ZM10.8333 15.0001H9.16667V13.3334H10.8333V15.0001ZM10.8333 11.6667H9.16667V10.0001H10.8333V11.6667ZM10.8333 8.33341H9.16667V6.66675H10.8333V8.33341ZM20.8333 21.6667H12.5V20.0001H20.8333V21.6667ZM20.8333 18.3334H12.5V16.6667H20.8333V18.3334ZM20.8333 15.0001H12.5V13.3334H20.8333V15.0001ZM20.8333 11.6667H12.5V10.0001H20.8333V11.6667ZM20.8333 8.33341H12.5V6.66675H20.8333V8.33341Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Orders') }}</span>
                            </a>
                        </li>

                        @if (addon_is_activated('refund_request'))
                            <li class="plx-side-nav-item mr-0">
                                <a href="{{ route('vendor_refund_request') }}" class="plx-side-nav-link {{ areActiveRoutes(['vendor_refund_request','reason_show'])}}">
                                    <i class="las la-backward plx-side-nav-icon"></i>
                                    <span class="plx-side-nav-text">{{ translate('Received Refund Request') }}</span>
                                </a>
                            </li>
                        @endif
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('reviews.seller') }}" class="plx-side-nav-link {{ areActiveRoutes(['reviews.seller'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.6721 9.13799L6.50571 2.89129V2.88909L2.06143 4.64928C1.62 4.82353 1.23214 5.09263 0.915 5.4257L15 11.6393L20.6721 9.13799ZM12.6943 0.440699L9.37286 1.75533L23.3936 7.93585L29.085 5.4257C28.7679 5.09043 28.38 4.82574 27.9407 4.64928L17.3079 0.440699C15.823 -0.1469 14.1792 -0.1469 12.6943 0.440699ZM29.9851 7.42943L29.9871 7.42853H29.985C29.985 7.42883 29.9851 7.42913 29.9851 7.42943ZM29.9851 7.42943L16.0714 13.5671V30C16.4914 29.9272 16.9071 29.8103 17.3079 29.6515L27.9407 25.4407C28.5469 25.2005 29.0681 24.7768 29.4357 24.2255C29.8034 23.6743 30.0001 23.0213 30 22.3527V7.73733C30 7.63397 29.9957 7.53061 29.9851 7.42943ZM13.9286 13.5671V30C13.5086 29.9272 13.095 29.8103 12.6921 29.6515L2.06143 25.4407C1.45485 25.2008 0.933149 24.7773 0.565138 24.226C0.197127 23.6747 8.60197e-05 23.0215 0 22.3527V7.73733C0.000337785 7.63421 0.00534315 7.53117 0.0149999 7.42853L13.9286 13.5671ZM20.5513 15.7009C21.1434 15.089 21.9411 14.75 22.7675 14.75C23.5939 14.75 24.3917 15.089 24.9838 15.7009C25.5767 16.3135 25.914 17.1496 25.914 18.0263C25.914 18.8961 25.582 19.7259 24.9978 20.3372C24.989 20.3459 24.9804 20.3547 24.9722 20.3637C24.3813 20.9681 23.5885 21.3026 22.7675 21.3026C21.9411 21.3026 21.1434 20.9636 20.5513 20.3518C19.9584 19.7391 19.6211 18.903 19.6211 18.0263C19.6211 17.1496 19.9584 16.3135 20.5513 15.7009ZM27.414 18.0263C27.414 19.0378 27.1017 20.0191 26.5285 20.8312L28.1202 22.4789C28.408 22.7768 28.3998 23.2516 28.1019 23.5394C27.8039 23.8272 27.3291 23.819 27.0414 23.5211L25.4798 21.9046C24.6965 22.4834 23.7495 22.8026 22.7675 22.8026C21.5271 22.8026 20.3427 22.2932 19.4734 21.3949C18.6049 20.4974 18.1211 19.2853 18.1211 18.0263C18.1211 16.7674 18.6049 15.5552 19.4734 14.6577C20.3427 13.7594 21.5271 13.25 22.7675 13.25C24.0079 13.25 25.1923 13.7594 26.0617 14.6577C26.9302 15.5552 27.414 16.7674 27.414 18.0263Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Product Reviews') }}</span>
                            </a>
                        </li>

                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('shops.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['shops.index'])}}">
                                <svg width="31" height="36" viewBox="0 0 31 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.3778 25.0299V33.1583H8.1289V25.0299H11.3768H11.3778ZM18.7061 23.4038H14.9097C14.6941 23.4038 14.4873 23.4895 14.3348 23.642C14.1823 23.7945 14.0967 24.0013 14.0967 24.2169V28.0133C14.0967 28.4621 14.4609 28.8263 14.9097 28.8263H18.7061C18.9218 28.8263 19.1286 28.7407 19.281 28.5882C19.4335 28.4357 19.5192 28.2289 19.5192 28.0133V24.2169C19.5192 24.0013 19.4335 23.7945 19.281 23.642C19.1286 23.4895 18.9218 23.4038 18.7061 23.4038ZM17.892 25.0299V27.2002H15.7228V25.0299H17.8909H17.892ZM8.85305 16.9005H3.7948V18.1635C3.7948 19.4427 4.74661 20.5018 5.98028 20.6687L6.15048 20.6861L6.32393 20.6915C7.66166 20.6915 8.75765 19.6519 8.84655 18.3358L8.85197 18.1624V16.9016L8.85305 16.9005ZM15.5363 16.9005H10.4792V18.1635C10.4792 19.4427 11.431 20.5018 12.6646 20.6687L12.8348 20.6861L13.0083 20.6915C14.346 20.6915 15.442 19.6519 15.5309 18.3358L15.5363 18.1624V16.9016V16.9005ZM22.2218 16.9005H17.1646V18.1635C17.1646 19.4427 18.1164 20.5018 19.3512 20.6687L19.5203 20.6861L19.6937 20.6915C21.0325 20.6915 22.1274 19.6519 22.2163 18.3358L22.2228 18.1624L22.2218 16.9005ZM9.82221 13.1041H6.85837L4.84526 15.2744H9.15659L9.82221 13.1041ZM14.4913 13.1041H11.5242L10.8564 15.2744H15.1602L14.4935 13.1041H14.4913ZM19.1582 13.1041H16.1943L16.86 15.2744H21.1713L19.1593 13.1041H19.1582ZM2.38551 15.5346L5.90873 11.7382C6.036 11.6008 6.20678 11.5116 6.39222 11.4856L6.50497 11.478H19.5138C19.701 11.4781 19.8825 11.5428 20.0276 11.6612L20.11 11.7371L23.6571 15.5639L23.6896 15.6051C23.8002 15.7525 23.85 15.9194 23.85 16.0821V18.1645C23.85 19.2421 23.4392 20.2243 22.766 20.9614V32.3463C22.7659 32.5429 22.6946 32.7329 22.5653 32.881C22.4359 33.0291 22.2572 33.1253 22.0624 33.1518L21.9529 33.1594L13.005 33.1583V24.2169C13.005 24.0013 12.9194 23.7945 12.7669 23.642C12.6144 23.4895 12.4076 23.4038 12.192 23.4038H7.31802C7.10238 23.4038 6.89558 23.4895 6.7431 23.642C6.59063 23.7945 6.50497 24.0013 6.50497 24.2169V33.1583L4.06582 33.1594C3.86934 33.1593 3.67952 33.0882 3.53145 32.9591C3.38338 32.8299 3.28708 32.6515 3.26036 32.4569L3.25277 32.3463V20.9614C2.60385 20.2515 2.22245 19.3377 2.17412 18.377L2.1687 18.1635V16.1287C2.15928 15.9742 2.19547 15.8204 2.27277 15.6864L2.32697 15.604L2.38551 15.5335V15.5346Z" fill="#3D3D3D"/>
                                    <path d="M24.0066 5.34028C23.5978 5.34028 23.215 5.49888 22.9251 5.78872C22.6366 6.07856 22.4767 6.46138 22.4767 6.87017C22.4767 7.27895 22.6366 7.66177 22.9251 7.95161C23.215 8.24009 23.5978 8.40005 24.0066 8.40005C24.4154 8.40005 24.7982 8.24009 25.088 7.95161C25.3765 7.66177 25.5365 7.27895 25.5365 6.87017C25.5365 6.46138 25.3765 6.07856 25.088 5.78872C24.9464 5.64606 24.7779 5.53296 24.5923 5.45598C24.4066 5.37899 24.2075 5.33967 24.0066 5.34028ZM29.6435 8.56001L28.7493 7.79575C28.7917 7.53599 28.8136 7.27075 28.8136 7.00688C28.8136 6.74302 28.7917 6.47642 28.7493 6.21802L29.6435 5.45376C29.711 5.39594 29.7594 5.31892 29.7821 5.23296C29.8048 5.14699 29.8008 5.05615 29.7706 4.97251L29.7583 4.93696C29.5122 4.24884 29.1435 3.611 28.67 3.05435L28.6454 3.02563C28.5879 2.95803 28.5113 2.90943 28.4256 2.88625C28.34 2.86306 28.2493 2.86637 28.1656 2.89575L27.0554 3.29087C26.6452 2.95454 26.1886 2.68931 25.6937 2.50474L25.479 1.34399C25.4628 1.25655 25.4204 1.17611 25.3574 1.11335C25.2944 1.05059 25.2138 1.00848 25.1263 0.992627L25.0894 0.985791C24.3784 0.857275 23.6292 0.857275 22.9183 0.985791L22.8814 0.992627C22.7939 1.00848 22.7133 1.05059 22.6503 1.11335C22.5872 1.17611 22.5448 1.25655 22.5286 1.34399L22.3126 2.51021C21.8224 2.69625 21.3657 2.96084 20.9605 3.2936L19.8421 2.89575C19.7584 2.86614 19.6676 2.86271 19.5819 2.88591C19.4962 2.90911 19.4196 2.95784 19.3622 3.02563L19.3376 3.05435C18.865 3.6116 18.4964 4.24928 18.2493 4.93696L18.237 4.97251C18.1755 5.14341 18.2261 5.33481 18.3642 5.45376L19.2693 6.22622C19.2269 6.48325 19.2064 6.74575 19.2064 7.00552C19.2064 7.26802 19.2269 7.53052 19.2693 7.78481L18.3669 8.55728C18.2994 8.6151 18.251 8.69211 18.2283 8.77808C18.2056 8.86404 18.2096 8.95488 18.2398 9.03852L18.2521 9.07407C18.4995 9.76177 18.8646 10.3975 19.3404 10.9567L19.365 10.9854C19.4225 11.053 19.4991 11.1016 19.5848 11.1248C19.6704 11.148 19.7611 11.1447 19.8448 11.1153L20.9632 10.7174C21.3706 11.0524 21.8245 11.3176 22.3154 11.5008L22.5314 12.667C22.5476 12.7545 22.59 12.8349 22.653 12.8977C22.716 12.9604 22.7966 13.0026 22.8841 13.0184L22.921 13.0252C23.639 13.1545 24.3742 13.1545 25.0921 13.0252L25.129 13.0184C25.2165 13.0026 25.2971 12.9604 25.3601 12.8977C25.4232 12.8349 25.4656 12.7545 25.4818 12.667L25.6964 11.5063C26.1913 11.3204 26.648 11.0565 27.0581 10.7202L28.1683 11.1153C28.252 11.1449 28.3428 11.1483 28.4285 11.1251C28.5142 11.1019 28.5908 11.0532 28.6482 10.9854L28.6728 10.9567C29.1486 10.3948 29.5136 9.76177 29.7611 9.07407L29.7734 9.03852C29.8322 8.86899 29.7816 8.67895 29.6435 8.56001ZM24.0066 9.27368C22.679 9.27368 21.6031 8.1977 21.6031 6.87017C21.6031 5.54263 22.679 4.46665 24.0066 4.46665C25.3341 4.46665 26.4101 5.54263 26.4101 6.87017C26.4101 8.1977 25.3341 9.27368 24.0066 9.27368Z" fill="#3D3D3D"/>
                                </svg>

                                <span class="plx-side-nav-text">{{ translate('Shop Setting') }}</span>
                            </a>
                        </li>

                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('payments.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['payments.index'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 2.5C21.9037 2.5 27.5 8.09625 27.5 15C27.5 21.9037 21.9037 27.5 15 27.5C12.8725 27.5 10.8687 26.9688 9.115 26.0312L2.5 27.5L3.97 20.8875C3.0325 19.1325 2.5 17.1287 2.5 15C2.5 8.09625 8.09625 2.5 15 2.5ZM16.25 8.75H13.75V17.5H21.25V15H16.25V8.75Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Payment History') }}</span>
                            </a>
                        </li>

                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('withdraw_requests.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['withdraw_requests.index'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 0L18.75 5.625H16.875V9.375H13.125V5.625H11.25L15 0Z" fill="#3D3D3D"/>
                                    <path d="M28.125 13.125V28.125H1.875V13.125H28.125ZM30 11.25H0V30H30V11.25Z" fill="#3D3D3D"/>
                                    <path d="M15.25 15C15.9887 15 16.7201 15.1455 17.4026 15.4282C18.0851 15.7109 18.7051 16.1252 19.2275 16.6475C19.7498 17.1699 20.1641 17.7899 20.4468 18.4724C20.7295 19.1549 20.875 19.8863 20.875 20.625C20.875 21.3637 20.7295 22.0951 20.4468 22.7776C20.1641 23.4601 19.7498 24.0801 19.2275 24.6025C18.7051 25.1248 18.0851 25.5391 17.4026 25.8218C16.7201 26.1045 15.9887 26.25 15.25 26.25H24.625V24.375H26.5V16.875H24.625V15H15.25Z" fill="#3D3D3D"/>
                                    <path d="M9.625 20.625C9.625 19.1332 10.2176 17.7024 11.2725 16.6475C12.3274 15.5926 13.7582 15 15.25 15H5.875V16.875H4V24.375H5.875V26.25H15.25C13.7582 26.25 12.3274 25.6574 11.2725 24.6025C10.2176 23.5476 9.625 22.1168 9.625 20.625Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Money Withdraw') }}</span>
                            </a>
                        </li>

                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('commission-log.index') }}" class="plx-side-nav-link">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.75 10C13.75 12.7625 11.5125 15 8.75 15C5.9875 15 3.75 12.7625 3.75 10C3.75 7.2375 5.9875 5 8.75 5C11.5125 5 13.75 7.2375 13.75 10ZM13.75 18.4V25H0V22.5C0 19.7375 3.9125 17.5 8.75 17.5C10.625 17.5 12.3375 17.8375 13.75 18.4ZM30 25H16.25V3.75H30V25ZM20 14.375C20 13.5462 20.3292 12.7513 20.9153 12.1653C21.5013 11.5792 22.2962 11.25 23.125 11.25C23.9538 11.25 24.7487 11.5792 25.3347 12.1653C25.9208 12.7513 26.25 13.5462 26.25 14.375C26.25 15.2038 25.9208 15.9987 25.3347 16.5847C24.7487 17.1708 23.9538 17.5 23.125 17.5C22.2962 17.5 21.5013 17.1708 20.9153 16.5847C20.3292 15.9987 20 15.2038 20 14.375ZM27.5 8.75C26.837 8.75 26.2011 8.48661 25.7322 8.01777C25.2634 7.54893 25 6.91304 25 6.25H21.25C21.25 7.6375 20.1375 8.75 18.75 8.75V20C19.413 20 20.0489 20.2634 20.5178 20.7322C20.9866 21.2011 21.25 21.837 21.25 22.5H25C25 21.125 26.125 20 27.5 20V8.75Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Commission History') }}</span>
                            </a>
                        </li>

                    @endif

                    @if (get_setting('conversation_system') == 1)
                        @php
                            $conversation = \App\Models\Conversation::where('sender_id', Auth::user()->id)->where('sender_viewed', 0)->get();
                        @endphp
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('conversations.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['conversations.index', 'conversations.show'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.2175 17.1388C23.514 17.1349 23.7973 17.0154 24.0069 16.8057C24.2166 16.596 24.3361 16.3127 24.34 16.0162C24.34 15.3937 23.8412 14.8938 23.2175 14.8938C22.5938 14.8938 22.095 15.3937 22.095 16.0162C22.095 16.6412 22.595 17.1388 23.2175 17.1388ZM17.6863 17.1388C17.9827 17.1349 18.266 17.0154 18.4757 16.8057C18.6854 16.596 18.8049 16.3127 18.8088 16.0162C18.8088 15.3937 18.3088 14.8938 17.6863 14.8938C17.0613 14.8938 16.5638 15.3937 16.5638 16.0162C16.5638 16.6412 17.0625 17.1388 17.6863 17.1388ZM25.895 23.4387C25.8149 23.4833 25.751 23.552 25.7123 23.6351C25.6737 23.7181 25.6624 23.8113 25.68 23.9013C25.68 23.9613 25.68 24.0225 25.7113 24.085C25.8337 24.6062 26.0788 25.4363 26.0788 25.4675C26.0788 25.5588 26.11 25.62 26.11 25.6825C26.11 25.7187 26.1028 25.7546 26.0889 25.788C26.0751 25.8215 26.0547 25.8518 26.029 25.8774C26.0033 25.903 25.9729 25.9232 25.9394 25.9369C25.9059 25.9507 25.87 25.9577 25.8337 25.9575C25.7712 25.9575 25.7413 25.9275 25.68 25.8975L23.8687 24.8525C23.7365 24.7797 23.5895 24.7378 23.4387 24.73C23.3475 24.73 23.255 24.73 23.1938 24.76C22.3337 25.0063 21.4437 25.1287 20.4925 25.1287C15.9175 25.1287 12.2337 22.0575 12.2337 18.2475C12.2337 14.4387 15.9175 11.3663 20.4925 11.3663C25.0662 11.3663 28.75 14.4387 28.75 18.2475C28.75 20.3062 27.645 22.18 25.895 23.44V23.4387ZM20.8413 10.1237C20.7246 10.1199 20.6079 10.1178 20.4912 10.1175C15.2738 10.1175 10.9837 13.6925 10.9837 18.2487C10.9837 18.9412 11.0838 19.6112 11.2688 20.2487H11.1575C10.0653 20.2377 8.97934 20.0831 7.9275 19.7887C7.835 19.7575 7.7425 19.7575 7.65 19.7575C7.46527 19.7614 7.28492 19.8145 7.1275 19.9112L4.9425 21.1675C4.88 21.1987 4.81875 21.23 4.7575 21.23C4.66829 21.229 4.58301 21.1932 4.51993 21.1301C4.45685 21.067 4.42097 20.9817 4.42 20.8925C4.42 20.8 4.45 20.7388 4.48125 20.6462C4.51125 20.6163 4.78875 19.6038 4.9425 18.9913C4.9425 18.9288 4.9725 18.8375 4.9725 18.7762C4.97216 18.6691 4.94705 18.5635 4.89913 18.4676C4.85121 18.3718 4.78177 18.2883 4.69625 18.2238C2.5725 16.72 1.25 14.4825 1.25 11.9975C1.25 7.43125 5.7125 3.75 11.1875 3.75C15.8938 3.75 19.85 6.46125 20.8413 10.1225V10.1237ZM14.3988 10.6463C15.115 10.6463 15.6812 10.05 15.6812 9.36375C15.6812 8.6475 15.115 8.08125 14.3988 8.08125C13.6825 8.08125 13.1163 8.6475 13.1163 9.36375C13.1163 10.08 13.6825 10.6463 14.3988 10.6463ZM7.82375 10.6463C8.54 10.6463 9.1075 10.05 9.1075 9.36375C9.1075 8.6475 8.54 8.08125 7.82375 8.08125C7.10875 8.08125 6.54125 8.6475 6.54125 9.36375C6.54125 10.08 7.10875 10.6463 7.82375 10.6463Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{ translate('Conversations') }}</span>
                                @if (count($conversation) > 0)
                                    <span class="badge badge-success">({{ count($conversation) }})</span>
                                @endif
                            </a>
                        </li>
                    @endif


                    @if (get_setting('wallet_system') == 1)
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('wallet.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['wallet.index'])}}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.5 7.5H18.75C16.7609 7.5 14.8532 8.29018 13.4467 9.6967C12.0402 11.1032 11.25 13.0109 11.25 15C11.25 16.9891 12.0402 18.8968 13.4467 20.3033C14.8532 21.7098 16.7609 22.5 18.75 22.5H27.5V25C27.5 25.3315 27.3683 25.6495 27.1339 25.8839C26.8995 26.1183 26.5815 26.25 26.25 26.25H3.75C3.41848 26.25 3.10054 26.1183 2.86612 25.8839C2.6317 25.6495 2.5 25.3315 2.5 25V5C2.5 4.66848 2.6317 4.35054 2.86612 4.11612C3.10054 3.8817 3.41848 3.75 3.75 3.75H26.25C26.5815 3.75 26.8995 3.8817 27.1339 4.11612C27.3683 4.35054 27.5 4.66848 27.5 5V7.5ZM18.75 10H28.75V20H18.75C17.4239 20 16.1521 19.4732 15.2145 18.5355C14.2768 17.5979 13.75 16.3261 13.75 15C13.75 13.6739 14.2768 12.4021 15.2145 11.4645C16.1521 10.5268 17.4239 10 18.75 10ZM18.75 13.75V16.25H22.5V13.75H18.75Z" fill="#3D3D3D"/>
                                </svg>
                                <span class="plx-side-nav-text">{{translate('My Wallet')}}</span>
                            </a>
                        </li>
                    @endif

                    @if (addon_is_activated('club_point'))
                        <li class="plx-side-nav-item mr-0">
                            <a href="{{ route('earnng_point_for_user') }}" class="plx-side-nav-link {{ areActiveRoutes(['earnng_point_for_user'])}}">
                                <i class="las la-dollar-sign plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('Earning Points')}}</span>
                            </a>
                        </li>
                    @endif

                    @if (addon_is_activated('affiliate_system') && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                        <li class="plx-side-nav-item mr-0">
                            <a href="javascript:void(0);" class="plx-side-nav-link {{ areActiveRoutes(['affiliate.user.index', 'affiliate.payment_settings'])}}">
                                <i class="las la-dollar-sign plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{ translate('Affiliate') }}</span>
                                <span class="plx-side-nav-arrow"></span>
                            </a>
                            <ul class="plx-side-nav-list level-2">
                                <li class="plx-side-nav-item">
                                    <a href="{{ route('affiliate.user.index') }}" class="plx-side-nav-link">
                                        <span class="plx-side-nav-text">{{ translate('Affiliate System') }}</span>
                                    </a>
                                </li>
                                <li class="plx-side-nav-item">
                                    <a href="{{ route('affiliate.user.payment_history') }}" class="plx-side-nav-link">
                                        <span class="plx-side-nav-text">{{ translate('Payment History') }}</span>
                                    </a>
                                </li>
                                <li class="plx-side-nav-item">
                                    <a href="{{ route('affiliate.user.withdraw_request_history') }}" class="plx-side-nav-link">
                                        <span class="plx-side-nav-text">{{ translate('Withdraw request history') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @php
                        $support_ticket = DB::table('tickets')
                                    ->where('client_viewed', 0)
                                    ->where('user_id', Auth::user()->id)
                                    ->count();
                    @endphp

                    <li class="plx-side-nav-item mr-0">
                        <a href="{{ route('support_ticket.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['support_ticket.index'])}}">
                            <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1_13081)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.8909 21.3423C13.3462 21.3423 10.7609 19.8317 9.25208 17.8323C2.01326 17.8323 1.79443 28.1734 1.79443 28.1734H29.9856C29.9856 28.1734 30.5538 17.7864 22.4133 17.7864C20.9062 19.8105 18.4356 21.3423 15.8909 21.3423Z" fill="#3D3D3D"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.9544 8.94526C21.9544 11.9206 19.2385 17.61 15.8856 17.61C12.538 17.61 9.82031 11.9188 9.82031 8.94526C9.82031 5.97173 12.5362 3.55762 15.8856 3.55762C19.2385 3.55938 21.9544 5.9735 21.9544 8.94526Z" fill="#3D3D3D"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.6611 6.37764C24.6611 5.82 23.8846 5.37 22.9211 5.36647V4.21764C22.9211 4.04647 22.9864 0.0388184 15.9064 0.0388184C8.82993 0.0388184 8.89522 4.04647 8.89522 4.21764V5.40705C8.87758 5.40705 8.86346 5.40176 8.84758 5.40176C7.88934 5.40176 7.11816 5.8447 7.11816 6.39352V11.2535C7.11816 11.7988 7.89111 12.2435 8.84758 12.2435C9.80405 12.2435 10.5805 11.7988 10.5805 11.2535V6.39352C10.5805 6.31764 10.5329 6.24882 10.5046 6.17823V4.85294C10.5046 4.73117 9.9964 1.70647 15.9064 1.70647C21.8182 1.70647 21.204 4.73117 21.204 4.85294V6.24882C21.1935 6.29294 21.1599 6.33176 21.1599 6.37764V11.3488C21.1599 11.9082 21.9417 12.3618 22.9105 12.3618C22.9317 12.3618 22.9476 12.3547 22.9688 12.3547V14.1706H21.2323V15.8823H24.6788L24.6611 6.37764Z" fill="#3D3D3D"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_1_13081">
                                        <rect width="30" height="28.2353" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>

                            <span class="plx-side-nav-text">{{translate('Support Ticket')}}</span>
                            @if($support_ticket > 0)<span class="ml-2 badge badge-inline badge-success">{{ $support_ticket }}</span> @endif
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        @if (get_setting('vendor_system_activation') == 1 && Auth::user()->user_type == 'customer')
            <div>
                <a href="{{ route('shops.create') }}" class="btn btn-block btn-action-button rounded-0">
                    </i>{{ translate('Be A Seller') }}
                </a>
            </div>
        @endif


    </div>

    <div class="fixed-bottom d-xl-none bg-white border-top d-flex justify-content-between px-2" style="box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.10);">
        <a class="btn btn-sm p-2 d-flex align-items-center" href="{{ route('logout') }}">
            <i class="las la-sign-out-alt fs-18 mr-2"></i>
            <span>{{ translate('Logout') }}</span>
        </a>
        <button class="btn btn-sm p-2 " data-toggle="class-toggle" data-backdrop="static" data-target=".plx-mobile-side-nav" data-same=".mobile-side-nav-thumb">
            <i class="las la-times la-2x"></i>
        </button>
    </div>
</div>
