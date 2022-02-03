<div class="plx-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="plx-side-nav-logo-wrap">
        <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
            @if(get_setting('system_logo_white') != null)
                <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white')) }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
            @else
                <img class="mw-100" src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
            @endif
        </a>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            @if (addon_is_activated('pos_system'))
                <div class="d-flex justify-content-around align-items-center align-items-stretch ml-3">
                    <div class="plx-topbar-item">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-icon btn-circle btn-light" href="{{ route('poin-of-sales.index') }}" target="_blank" title="{{ translate('POS') }}">
                                <i class="las la-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="d-flex justify-content-around align-items-center align-items-stretch ml-3">
                <div class="plx-topbar-item">
                    <div class="d-flex align-items-center">
<!--                        <a class="btn btn-action-button btn-sm d-flex align-items-center" href="{{ route('cache.clear')}}">
                            <i class="las la-hdd fs-20"></i>
                            <span class="fw-500 ml-1 mr-0 d-none d-md-block">{{ translate('Clear Cache') }}</span>
                        </a>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            <div class="d-flex justify-content-around align-items-center align-items-stretch">
                <div class="plx-topbar-item">
                    <div class="d-flex align-items-center">
                        <a class="custom-header-menu-item" href="{{ route('home')}}" target="_blank" title="{{ translate('Browse Website') }}">
                            <img src="{{ static_asset('assets/img/favicon.ico') }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
                        </a>
                    </div>
                </div>
            </div>
            {{-- language --}}
            @php
                if(Session::has('locale')){
                    $locale = Session::get('locale', Config::get('app.locale'));
                }
                else{
                    $locale = env('DEFAULT_LANGUAGE');
                }
            @endphp
            <div class="plx-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown " id="lang-change">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon custom-header-menu-item">
                            <img src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" />
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xs">
                        @foreach (\App\Models\Language::all() as $key => $language)
                            <li>
                                <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language->code) active @endif">
                                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-2">
                                    <span class="language">{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="plx-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-0 d-flex justify-content-center align-items-center custom-header-menu-item">
                            <span class="d-flex align-items-center position-relative">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="28" viewBox="0 0 24 28" fill="none">
                                    <path d="M20.0002 8.66675C20.0002 6.54502 19.1573 4.51019 17.657 3.00989C16.1567 1.5096 14.1219 0.666748 12.0002 0.666748C9.87845 0.666748 7.84362 1.5096 6.34333 3.00989C4.84304 4.51019 4.00018 6.54502 4.00018 8.66675C4.00018 18.0001 0.000183105 20.6667 0.000183105 20.6667H24.0002C24.0002 20.6667 20.0002 18.0001 20.0002 8.66675Z" fill="#3D3D3D"/>
                                    <path d="M14.3068 26.0001C14.0724 26.4042 13.736 26.7396 13.3311 26.9728C12.9263 27.206 12.4674 27.3287 12.0002 27.3287C11.533 27.3287 11.074 27.206 10.6692 26.9728C10.2644 26.7396 9.92793 26.4042 9.69352 26.0001" fill="#3D3D3D"/>
                               </svg>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="badge badge-sm badge-circle badge-primary position-absolute absolute-top-right"></span>
                                @endif
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                        </div>
                        <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                            <ul class="list-group list-group-flush">
                                @forelse(Auth::user()->unreadNotifications->take(20) as $notification)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0">
                                        <div class="media text-inherit">
                                            <div class="media-body">
                                                @if($notification->type == 'App\Notifications\OrderNotification')
                                                    <p class="mb-1 text-truncate-2 h6">
                                                        {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ date("F j Y, g:i a", strtotime($notification->created_at)) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
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
                            <a href="{{ route('admin.all-notification') }}" class="text-reset d-block py-2">
                                {{translate('View All Notifications')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="plx-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center custom-profile">
                            <span class="avatar avatar-sm mr-lg-2">
                                <img
                                    src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                                >
                            </span>
                            <span class="d-none d-lg-block">
                                <span class="d-block fw-500">{{Auth::user()->name}}</span>
                                <span class="d-block small opacity-60">{{Auth::user()->user_type}}</span>
                            </span>
                           <svg class="d-none d-lg-block" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L4 4L7 1" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>{{translate('Profile')}}</span>
                        </a>
                        <a href="{{ route('logout')}}" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>{{translate('Logout')}}</span>
                        </a>
                    </div>
                </div>
            </div><!-- .plx-topbar-item -->
        </div>
    </div>
</div><!-- .plx-topbar -->
