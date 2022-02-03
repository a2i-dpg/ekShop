<div class="plx-sidebar-wrap position-relative">
    <div class="plx-sidebar left c-scrollbar">
        <div class="plx-side-nav-wrap">
            <div class="pr-10px">
                <input class="form-control border-0 form-control-sm side-menu-search" type="text" name="" placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="plx-side-nav-list" id="search-menu"></ul>
            <ul class="plx-side-nav-list" id="main-menu" data-toggle="plx-side-menu">
                <li class="plx-side-nav-item plx-side-nav-item-admin @if(request()->routeIs('/admin')) mm-active @endif">
                    <a href="{{route('admin.dashboard')}}" class="plx-side-nav-link @if(request()->routeIs('/admin')) active @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M0 17.7778H14.2222V0H0V17.7778ZM0 32H14.2222V21.3333H0V32ZM17.7778 32H32V14.2222H17.7778V32ZM17.7778 0V10.6667H32V0H17.7778Z" fill="#3D3D3D" fill-opacity="0.7"/>
                        </svg>

                        <span class="plx-side-nav-text plx-side-nav-text-hide">{{translate('Dashboard')}}</span>
                    </a>
                </li>

                <!-- POS Addon-->
                @if (addon_is_activated('pos_system'))
                    @if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="pos-system-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-tasks plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('POS System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

            <!-- Product -->
                @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin @if(request()->is('admin/products/*')) mm-active @endif" id="product-menu">
                        <a href="#" class="plx-side-nav-link @if(request()->is('admin/products/*')) active @endif">
                            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_248_342)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.67244 0.449463C2.40882 0.449463 3.00578 1.04642 3.00578 1.7828V11.1161H7.00578C6.2694 11.1161 5.67244 10.5192 5.67244 9.7828V7.11613C5.67244 6.37975 6.2694 5.7828 7.00578 5.7828H12.3391C13.0755 5.7828 13.6724 6.37975 13.6724 7.11613V9.7828C13.6724 10.5192 13.0755 11.1161 12.3391 11.1161H17.6724C16.9361 11.1161 16.3391 10.5192 16.3391 9.7828V4.44946C16.3391 3.71308 16.9361 3.11613 17.6724 3.11613H25.6724C26.4088 3.11613 27.0058 3.71308 27.0058 4.44946V9.7828C27.0058 10.5192 26.4088 11.1161 25.6724 11.1161H29.6724V1.7828C29.6724 1.04642 30.2694 0.449463 31.0058 0.449463C31.7422 0.449463 32.3391 1.04642 32.3391 1.7828V31.1161C32.3391 31.8525 31.7422 32.4495 31.0058 32.4495C30.2694 32.4495 29.6724 31.8525 29.6724 31.1161V29.7828H3.00578V31.1161C3.00578 31.8525 2.40882 32.4495 1.67244 32.4495C0.936065 32.4495 0.339111 31.8525 0.339111 31.1161V1.7828C0.339111 1.04642 0.936065 0.449463 1.67244 0.449463ZM29.6724 27.1161H25.6724C26.4088 27.1161 27.0058 26.5192 27.0058 25.7828V20.4495C27.0058 19.7131 26.4088 19.1161 25.6724 19.1161H19.0058C18.2694 19.1161 17.6724 19.7131 17.6724 20.4495V25.7828C17.6724 26.5192 18.2694 27.1161 19.0058 27.1161H13.6724C14.4088 27.1161 15.0058 26.5192 15.0058 25.7828V17.7828C15.0058 17.0464 14.4088 16.4495 13.6724 16.4495H7.00578C6.2694 16.4495 5.67244 17.0464 5.67244 17.7828V25.7828C5.67244 26.5192 6.2694 27.1161 7.00578 27.1161H3.00578V13.7828H29.6724V27.1161Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_248_342">
                                        <rect width="32" height="32" fill="white" transform="translate(0.339111 0.449463)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{translate('Products')}}</span>
                        </a>
                    </li>
                @endif

                <!-- Auction Product -->
                @if(addon_is_activated('auction'))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="auction-menu">
                        <a href="#" class="plx-side-nav-link">
                            <i class="las la-gavel plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">{{translate('Auction Products')}}</span>
                            @if (env("DEMO_MODE") == "On")
                                <span class="badge badge-inline badge-danger">Addon</span>
                            @endif
                        </a>
                    </li>
                @endif

                <!-- Wholesale Product -->
                @if(addon_is_activated('wholesale'))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="wholesale-menu">
                        <a href="#" class="plx-side-nav-link">
                            <i class="las la-luggage-cart plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">{{translate('Wholesale Products')}}</span>
                            @if (env("DEMO_MODE") == "On")
                                <span class="badge badge-inline badge-danger">Addon</span>
                            @endif
                        </a>
                    </li>
                @endif

                <!-- Sale -->
                <li class="plx-side-nav-item plx-side-nav-item-admin" id="sale-menu">
                    <a href="#" class="plx-side-nav-link">
                        <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.498 1.05371C19.9041 1.16 19.06 1.43509 18.4161 1.73518C17.2282 2.28536 17.4282 2.0978 9.18806 10.3255C4.96169 14.5394 1.35426 18.178 1.1667 18.4031C0.178878 19.6035 0.0663413 21.2415 0.879106 22.5045C0.985391 22.667 3.23612 24.9615 5.87448 27.5936C9.53193 31.2385 10.7511 32.4202 11.0012 32.5452C11.42 32.7703 12.1953 32.9641 12.6392 32.9641C13.1706 32.9641 13.7833 32.8078 14.2897 32.5515C14.7149 32.3327 15.2213 31.8325 22.6862 24.3738C29.5197 17.5466 30.6826 16.3524 30.9889 15.8898C31.6141 14.9332 32.058 13.8204 32.2456 12.7263C32.3206 12.2886 32.3394 11.4446 32.3394 8.11226C32.3394 4.25476 32.3331 4.01093 32.2143 3.55453C32.058 2.92307 31.7829 2.45417 31.314 1.97901C30.8389 1.51011 30.37 1.23502 29.7385 1.07872C29.2821 0.959932 29.0508 0.95368 25.1245 0.959932C21.8359 0.966184 20.8919 0.98494 20.498 1.05371ZM26.9126 6.11786C27.0001 6.16788 27.1377 6.30542 27.2127 6.42421C27.3252 6.60552 27.3502 6.71806 27.3252 6.99315C27.3002 7.28699 27.2627 7.37452 27.0626 7.56834C26.8501 7.78716 26.8126 7.79966 26.4437 7.79966C26.0185 7.79966 25.806 7.69338 25.6184 7.37452C25.4246 7.04942 25.5184 6.44297 25.7997 6.21164C26.0873 5.97407 26.5437 5.93655 26.9126 6.11786ZM21.7859 7.13069C21.8797 7.22447 21.9735 7.39328 21.9985 7.50582C22.036 7.70588 22.0047 7.74339 20.9857 8.77498L19.9291 9.83157L20.6355 10.5381L21.3358 11.2383L21.9172 10.6568C22.5612 10.0129 22.6925 9.96912 23.0176 10.2442C23.1614 10.363 23.2114 10.4568 23.2114 10.6006C23.2114 10.7631 23.1176 10.8944 22.6362 11.3758L22.0548 11.9573L22.7737 12.6763L23.4865 13.3952L24.5556 12.3324C25.1433 11.7447 25.6622 11.2695 25.7059 11.2695C25.8435 11.2695 26.1373 11.4509 26.2686 11.6197C26.5312 11.9573 26.5 12.0073 25.0745 13.4453C23.7803 14.7394 23.524 14.9582 23.2927 14.9582C23.1739 14.9582 18.4786 10.313 18.4036 10.1129C18.3723 10.0441 18.3786 9.9191 18.4098 9.82532C18.4411 9.73779 19.0913 9.03756 19.8665 8.27482C21.1732 6.96814 21.2733 6.88061 21.4421 6.91812C21.5358 6.94313 21.6921 7.03691 21.7859 7.13069ZM17.9597 14.7394L20.0541 16.8339L20.9606 15.9273C21.9797 14.902 22.0485 14.8707 22.4236 15.2333C22.5987 15.3896 22.6487 15.4897 22.6487 15.6522C22.6487 15.846 22.5362 15.9773 21.4483 17.0652C20.7856 17.7216 20.1729 18.2906 20.0979 18.3343C20.0166 18.3719 19.8853 18.3906 19.8165 18.3719C19.7415 18.3531 18.6161 17.2715 17.3095 15.9711C14.7649 13.414 14.7961 13.4578 15.065 13.0951C15.2275 12.8763 15.5714 12.645 15.7339 12.645C15.8152 12.645 16.5592 13.339 17.9597 14.7394ZM15.959 17.0277C17.5908 17.8904 18.9788 18.6407 19.0413 18.697C19.2726 18.9033 19.0663 19.541 18.6974 19.7598C18.5286 19.8598 18.5099 19.8598 18.1347 19.6473C17.9159 19.5285 17.6096 19.3597 17.447 19.2721L17.1469 19.1158L16.3341 19.9286L15.5214 20.7414L15.8652 21.3603C16.2154 21.9918 16.2591 22.1293 16.1466 22.3356C15.959 22.6858 15.2338 22.8421 15.0587 22.567C14.7024 22.0168 11.8952 16.5838 11.8952 16.4587C11.8952 16.1899 12.2203 15.746 12.5267 15.596C12.6767 15.5209 12.8455 15.4584 12.8955 15.4584C12.9518 15.4584 14.3272 16.1649 15.959 17.0277ZM10.501 18.8908C10.6698 19.1409 10.6886 19.466 10.5385 19.6035C10.476 19.6535 10.2572 19.7661 10.0508 19.8411C9.78201 19.9411 9.57569 20.0787 9.31936 20.335C8.78793 20.8727 8.69415 21.3416 9.06302 21.6854C9.3131 21.9168 9.69448 21.8918 10.5698 21.5666C11.8202 21.0977 12.2953 21.0415 12.9393 21.2853C13.452 21.4729 14.0709 22.0981 14.2647 22.617C14.5461 23.361 14.3648 24.1362 13.7333 24.8802C13.4332 25.2303 12.783 25.6867 12.3328 25.8618C11.9452 26.0181 11.4013 26.0243 11.1825 25.8806C10.8261 25.643 10.7448 25.0553 11.0387 24.874C11.1137 24.824 11.32 24.7739 11.5013 24.7552C12.0265 24.6989 12.3203 24.5801 12.6267 24.3113C13.2581 23.7549 13.3019 23.0796 12.733 22.7045C12.4204 22.4982 12.014 22.5482 11.0074 22.9108C10.2071 23.1984 10.0571 23.2297 9.58194 23.2359C9.11929 23.2422 9.00675 23.2172 8.73792 23.0734C8.35029 22.8733 7.92515 22.4232 7.75635 22.0418C7.56879 21.6229 7.61255 20.9289 7.85638 20.4288C8.0877 19.9536 8.96924 19.0658 9.4569 18.8158C9.94456 18.5719 10.3009 18.5969 10.501 18.8908Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            <path d="M13.458 17.059C13.458 17.1028 14.9022 19.6724 14.9647 19.7411C15.0023 19.7786 15.2461 19.5786 15.6275 19.1972C15.9651 18.8596 16.2214 18.5783 16.2089 18.5658C16.1214 18.497 13.458 17.034 13.458 17.059Z" fill="#3D3D3D" fill-opacity="0.7"/>
                        </svg>
                        <span class="plx-side-nav-text plx-side-nav-text-hide">{{translate('Sales')}}</span>
{{--                        <span class="plx-side-nav-arrow"></span>--}}
                    </a>
                </li>

                <!-- Deliver Boy Addon-->
                @if (addon_is_activated('delivery_boy'))
                    @if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="delivery-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-truck plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('Delivery Boy')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

            <!-- Refund addon -->
                @if (addon_is_activated('refund_request'))
                    @if(Auth::user()->user_type == 'admin' || in_array('7', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="refund-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-backward plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{ translate('Refunds') }}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif


            <!-- Customers -->
                @if(Auth::user()->user_type == 'admin' || in_array('8', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="customer-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3384 0.55835C21.6401 0.55835 25.938 4.85627 25.938 10.158C25.938 15.4598 21.6401 19.7577 16.3384 19.7577C11.0366 19.7577 6.7387 15.4598 6.7387 10.158C6.7387 4.85627 11.0366 0.55835 16.3384 0.55835ZM1.9393 35.9155C1.05567 35.9155 0.339355 35.1992 0.339355 34.3156V30.9573C0.339355 26.5391 3.92095 22.9576 8.33908 22.9576H24.3396C28.7578 22.9576 32.3394 26.5391 32.3394 30.9573V34.3156C32.3394 35.1992 31.623 35.9155 30.7394 35.9155C29.8558 35.9155 2.82292 35.9155 1.9393 35.9155Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{ translate('Customers') }}</span>
                        </a>
                    </li>
                @endif

            <!-- Sellers -->
                @if((Auth::user()->user_type == 'admin' || in_array('9', json_decode(Auth::user()->staff->role->permissions))) && get_setting('vendor_system_activation') == 1)
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="seller-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg width="33" height="31" viewBox="0 0 33 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.34248 4.60941L0.376841 8.75155L0.358098 9.47626L0.339355 10.2072H0.845408H1.34521V20.1408V30.0745H16.3394H31.3335V20.1408V10.2072H31.8333H32.3394L32.3206 9.47626L32.3019 8.7453L24.3362 4.60317C19.9567 2.32906 16.3581 0.467283 16.3394 0.467283C16.3206 0.467283 12.722 2.32906 8.34248 4.60941ZM9.52952 19.2974V28.3876H6.18707H2.84463V26.1385C2.84463 24.7953 2.86962 23.8894 2.90085 23.8894C2.95708 23.8894 5.69351 23.3896 6.33077 23.2584C6.61815 23.2021 6.65564 23.1772 6.65564 23.0397V22.8898H4.75013H2.84463L2.85712 21.7527L2.87586 20.6094L4.75013 20.2658C6.51819 19.9409 6.6244 19.9097 6.64314 19.7785L6.66189 19.641H4.75638H2.84463V18.4915V17.3419L3.14451 17.2795C3.30695 17.2482 4.16286 17.0858 5.05002 16.9171C6.59941 16.6297 6.65564 16.611 6.65564 16.4735V16.3298H4.75013H2.84463V15.1865V14.0432L4.4565 13.7433C6.73061 13.3248 6.65564 13.3435 6.65564 13.1998C6.65564 13.0874 6.58692 13.0811 4.75013 13.0811H2.84463V11.6442V10.2072H6.18707H9.52952V19.2974ZM29.8341 15.9862V21.7652H20.4315H11.0289V15.9862V10.2072H20.4315H29.8341V15.9862Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M3.28223 11.988V12.644H3.93822H4.60046L4.58172 12.0005L4.56298 11.3633L3.92573 11.3446L3.28223 11.3258V11.988Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M5.03149 11.988V12.644H5.68749H6.34348V11.988V11.3321H5.68749H5.03149V11.988Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M3.28223 15.2992V15.9614L3.92573 15.9427L4.56298 15.9239L4.58172 15.2804L4.60046 14.6432H3.93822H3.28223V15.2992Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M5.03149 15.2991V15.9551H5.68749H6.34348V15.2991V14.6431H5.68749H5.03149V15.2991Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M3.28223 18.5791V19.2039H3.93822H4.59421V18.5791V17.9543H3.93822H3.28223V18.5791Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M5.03149 18.5791V19.2039H5.68749H6.34348V18.5791V17.9543H5.68749H5.03149V18.5791Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M3.28223 21.8589V22.5149H3.93822H4.60046L4.58172 21.8714L4.56298 21.2341L3.92573 21.2154L3.28223 21.1967V21.8589Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M5.03149 21.8589V22.5149H5.68749H6.34348V21.8589V21.2029H5.68749H5.03149V21.8589Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M18.7509 11.1754C18.1636 11.4003 17.7887 11.8938 17.7325 12.4998C17.6513 13.4307 18.2448 14.1679 19.1445 14.2492C19.8129 14.3116 20.3627 14.0242 20.6876 13.4432C20.9188 13.0121 20.9438 12.3811 20.7313 11.9813C20.5627 11.6689 20.2628 11.369 19.9691 11.2316C19.6693 11.0816 19.0632 11.0567 18.7509 11.1754ZM19.8692 11.5627C20.3065 11.7876 20.5314 12.1625 20.5314 12.681C20.5314 13.2745 20.1691 13.7369 19.5693 13.8993C18.8571 14.0867 18.0261 13.437 18.0261 12.681C18.0261 12.2062 18.4885 11.5939 18.9383 11.469C19.2257 11.394 19.6005 11.4315 19.8692 11.5627Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M19.2134 12.2687V12.7686H19.7132C20.113 12.7686 20.213 12.7498 20.213 12.6748C20.213 12.5999 20.1255 12.5811 19.7757 12.5811H19.3383V12.175C19.3383 11.9439 19.3133 11.7689 19.2759 11.7689C19.2384 11.7689 19.2134 11.9751 19.2134 12.2687Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M22.0247 12.3002V12.7063H22.2746H22.5245V14.2057V15.7051H22.2746H22.0247V16.1112V16.5173H22.2746H22.5245V18.0167V19.5161H22.2746H22.0247V19.9222V20.3283H22.2746H22.5245V20.8281V21.3279H22.9618H23.3991V20.8281V20.3283H25.6795H27.9598V20.8281V21.3279H28.3972H28.8345V20.8281V20.3283H29.0844H29.3343V19.9222V19.5161H29.0844H28.8345V18.0167V16.5173H29.0844H29.3343V16.1112V15.7051H29.0844H28.8345V14.2057V12.7063H29.0844H29.3343V12.3002V11.8941H25.6795H22.0247V12.3002ZM27.9598 14.2057V15.7051H25.6795H23.3991V14.2057V12.7063H25.6795H27.9598V14.2057ZM27.9598 18.0167V19.5161H25.6795H23.3991V18.0167V16.5173H25.6795H27.9598V18.0167Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M26.2355 13.4183C25.9981 13.5245 25.792 13.7744 25.7045 14.0743C25.6108 14.3992 25.717 14.749 25.9919 15.0177C26.2043 15.2238 26.2418 15.2363 26.6479 15.2363C27.054 15.2363 27.0915 15.2238 27.2976 15.0239C27.5663 14.7615 27.6725 14.4741 27.6163 14.1368C27.51 13.5245 26.8228 13.1621 26.2355 13.4183Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M24.5738 14.2432C24.2552 14.4119 24.2427 14.9617 24.5425 15.1741C24.6175 15.2241 24.7799 15.2678 24.9049 15.2678C25.0861 15.2678 25.1735 15.2241 25.2985 15.0741C25.5172 14.818 25.5109 14.5556 25.2798 14.3244C25.0736 14.1183 24.8424 14.0933 24.5738 14.2432Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M24.0239 18.3914V19.0786H24.3988H24.7736V18.3914V17.7042H24.3988H24.0239V18.3914Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M25.0857 18.3914V19.0786H25.4605H25.8354V18.3914V17.7042H25.4605H25.0857V18.3914Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M26.0857 18.3914V19.0786H26.8042H27.5226V18.3914V17.7042H26.8042H26.0857V18.3914Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M14.9648 13.362C14.2964 13.5744 13.859 14.2242 13.9153 14.9239C13.9527 15.3612 14.0652 15.6049 14.3526 15.8923C14.64 16.1859 14.9961 16.3296 15.4209 16.3296C15.8457 16.3296 16.1081 16.2296 16.4268 15.9547C16.8828 15.5486 17.0515 14.9739 16.8766 14.3804C16.6454 13.5807 15.7583 13.1058 14.9648 13.362Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M13.7406 16.9109C13.0346 17.3232 12.3724 18.2791 12.0037 19.4099C11.8663 19.8347 11.7039 20.5532 11.6289 21.0905L11.5977 21.3279H12.1474H12.7035L12.741 21.028C12.8347 20.397 13.0533 19.6473 13.3032 19.1412L13.5594 18.6102L13.5781 19.9659L13.5906 21.3279H13.903H14.2154V19.0788V16.8296H14.0467C13.9467 16.8359 13.8155 16.8671 13.7406 16.9109Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M14.6025 17.4355L14.6212 18.0477L15.4209 18.0665L16.2144 18.0852V17.4542V16.8294H15.4022H14.5837L14.6025 17.4355Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M16.6519 19.0789V21.328H16.9642H17.2766L17.2891 19.9661L17.3078 18.6104L17.5453 19.0914C17.7577 19.5287 18.0263 20.4659 18.12 21.0906L18.1575 21.328H18.6823C19.3008 21.328 19.2696 21.378 19.1259 20.5409C18.8822 19.1726 18.4074 18.1418 17.664 17.3733C17.2704 16.9672 17.0517 16.8298 16.808 16.8298H16.6519V19.0789Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{ translate('Sellers') }}</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type == 'admin' || in_array('22', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="uploaded-menu">
                        <a href="{{ route('uploaded-files.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['uploaded-files.create'])}}">
                            <svg width="33" height="31" viewBox="0 0 33 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.3389 16.3853L22.5067 22.5516L20.4498 24.6085L17.7926 21.9513V30.0699H14.8853V21.9484L12.228 24.6085L10.1711 22.5516L16.3389 16.3853ZM16.3389 0.99707C18.8348 0.997189 21.2436 1.91448 23.1074 3.57455C24.9711 5.23461 26.1598 7.52168 26.4475 10.0009C28.2563 10.4942 29.8341 11.6073 30.9054 13.1459C31.9766 14.6845 32.4731 16.5506 32.3081 18.4181C32.143 20.2855 31.327 22.0356 30.0025 23.3625C28.678 24.6894 26.9294 25.5086 25.0622 25.677L25.0608 22.8017C25.0631 20.5153 24.1675 18.3195 22.5668 16.6869C20.9662 15.0543 18.7885 14.1155 16.5025 14.0726C14.2165 14.0297 12.0051 14.8862 10.3444 16.4576C8.68364 18.029 7.70635 20.1898 7.62291 22.4746L7.61709 22.8017V25.677C5.74982 25.5088 4.00103 24.6898 2.67637 23.3631C1.3517 22.0363 0.535436 20.2862 0.370225 18.4187C0.205015 16.5512 0.701372 14.685 1.77254 13.1463C2.84372 11.6076 4.42157 10.4943 6.23032 10.0009C6.51771 7.52155 7.70636 5.2343 9.57017 3.57418C11.434 1.91405 13.843 0.996872 16.3389 0.99707V0.99707Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide text-nowrap">{{ translate('Uploaded Files') }}</span>
                        </a>
                    </li>
                @endif
            <!-- Reports -->
                @if(Auth::user()->user_type == 'admin' || in_array('10', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="report-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="38" viewBox="0 0 32 38" fill="none">
                                <path d="M32 11.3143L20 0H4C2.93913 0 1.92172 0.397346 1.17157 1.10463C0.421427 1.81191 0 2.77118 0 3.77143V33.9429C0 34.9431 0.421427 35.9024 1.17157 36.6097C1.92172 37.3169 2.93913 37.7143 4 37.7143H28C29.0609 37.7143 30.0783 37.3169 30.8284 36.6097C31.5786 35.9024 32 34.9431 32 33.9429V11.3143ZM10 32.0571H6V15.0857H10V32.0571ZM18 32.0571H14V20.7429H18V32.0571ZM26 32.0571H22V26.4H26V32.0571ZM20 13.2H18V3.77143L28 13.2H20Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
{{--                            <i class="las la-file-alt plx-side-nav-icon"></i>--}}
                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{ translate('Reports') }}</span>
{{--                            <span class="plx-side-nav-arrow"></span>--}}
                        </a>
                    </li>
                @endif

                @if(Auth::user()->user_type == 'admin' || in_array('23', json_decode(Auth::user()->staff->role->permissions)))
                <!--Blog System-->
                    <!--<li class="plx-side-nav-item">
                        <a href="#" class="plx-side-nav-link">
                            <i class="las la-bullhorn plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">{{ translate('Blog System') }}</span>
                            <span class="plx-side-nav-arrow"></span>
                        </a>
                        <ul class="plx-side-nav-list level-2">
                            <li class="plx-side-nav-item">
                                <a href="{{ route('blog.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['blog.create', 'blog.edit'])}}">
                                    <span class="plx-side-nav-text">{{ translate('All Posts') }}</span>
                                </a>
                            </li>
                            <li class="plx-side-nav-item">
                                <a href="{{ route('blog-category.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['blog-category.create', 'blog-category.edit'])}}">
                                    <span class="plx-side-nav-text">{{ translate('Categories') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>-->
                @endif

            <!-- marketing -->
                @if(Auth::user()->user_type == 'admin' || in_array('11', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="marketing-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.41859 10.7636C4.41859 8.7903 6.01859 7.17576 7.97415 7.17576H22.1964L29.3075 0H32.863V28.703H29.3075L22.1964 21.5273H7.97415C7.03116 21.5273 6.12679 21.1493 5.45999 20.4764C4.79319 19.8035 4.41859 18.891 4.41859 17.9394H0.863037V10.7636H4.41859ZM18.6408 26.9091V35.8788H13.3075L10.3386 26.9091H7.97415V23.3212H22.1964V26.9091H18.6408Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{ translate('Marketing') }}</span>
                        </a>
                    </li>
                @endif

            <!-- Support -->
                @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="support-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.73505 3.61281C9.59044 1.2714 13.1704 -0.00562433 16.863 1.86215e-05C20.5556 -0.0054914 24.1355 1.27151 26.991 3.61281C26.9708 3.63096 26.951 3.64963 26.9318 3.66881L21.2742 9.3248C19.9664 8.45833 18.4318 7.99745 16.863 8C15.231 8 13.7158 8.488 12.4518 9.3248L6.79424 3.66881C6.77498 3.64965 6.75524 3.63098 6.73505 3.61281V3.61281ZM4.47585 5.87201C2.13443 8.7274 0.857413 12.3074 0.863056 16C0.857546 19.6926 2.13455 23.2725 4.47585 26.128C4.494 26.1078 4.51267 26.088 4.53185 26.0688L10.1878 20.4112C9.32136 19.1034 8.86048 17.5688 8.86304 16C8.86304 14.368 9.35104 12.8528 10.1878 11.5888L4.53185 5.93121C4.51269 5.91194 4.49402 5.89221 4.47585 5.87201V5.87201ZM6.73505 28.3872C9.59044 30.7286 13.1704 32.0056 16.863 32C20.5557 32.0056 24.1356 30.7286 26.991 28.3872C26.9708 28.369 26.951 28.3504 26.9318 28.3312L21.2742 22.6752C19.9664 23.5417 18.4318 24.0025 16.863 24C15.2942 24.0025 13.7596 23.5417 12.4518 22.6752L6.79424 28.3312C6.77501 28.3504 6.75527 28.369 6.73505 28.3872V28.3872ZM29.2502 26.128C31.5916 23.2726 32.8686 19.6926 32.863 16C32.8686 12.3074 31.5916 8.7274 29.2502 5.87201C29.2321 5.89223 29.2134 5.91197 29.1942 5.93121L23.5382 11.5888C24.375 12.8528 24.863 14.3696 24.863 16C24.863 17.632 24.375 19.1472 23.5382 20.4112L29.1942 26.0688C29.2134 26.088 29.2321 26.1077 29.2502 26.128V26.128Z" fill="#3D3D3D" fill-opacity="0.7"/>
                                <path d="M16.8627 20.8002C19.5137 20.8002 21.6627 18.6511 21.6627 16.0002C21.6627 13.3492 19.5137 11.2002 16.8627 11.2002C14.2118 11.2002 12.0627 13.3492 12.0627 16.0002C12.0627 18.6511 14.2118 20.8002 16.8627 20.8002Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{translate('Support')}}</span>
                        </a>
                    </li>
                @endif

            <!-- Affiliate Addon -->
                @if (addon_is_activated('affiliate_system'))
                    @if(Auth::user()->user_type == 'admin' || in_array('15', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="affiliate-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-link plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text plx-side-nav-text-hide text-nowrap">{{translate('Affiliate System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

            <!-- Offline Payment Addon-->
                @if (addon_is_activated('offline_payment'))
                    @if(Auth::user()->user_type == 'admin' || in_array('16', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="offline-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-money-check-alt plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('Offline Payment System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

            <!-- Paytm Addon -->
                @if (addon_is_activated('paytm'))
                    @if(Auth::user()->user_type == 'admin' || in_array('17', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="payment-geteway-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-mobile-alt plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('Paytm Payment Gateway')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

            <!-- Club Point Addon-->
                @if (addon_is_activated('club_point'))
                    @if(Auth::user()->user_type == 'admin' || in_array('18', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="club-point-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="lab la-btc plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('Club Point System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

            <!--OTP addon -->
                @if (addon_is_activated('otp_system'))
                    @if(Auth::user()->user_type == 'admin' || in_array('19', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="otp-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-phone plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('OTP System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

                @if(addon_is_activated('african_pg'))
                    @if(Auth::user()->user_type == 'admin' || in_array('19', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="plx-side-nav-item plx-side-nav-item-admin" id="african-payment-menu">
                            <a href="#" class="plx-side-nav-link">
                                <i class="las la-phone plx-side-nav-icon"></i>
                                <span class="plx-side-nav-text">{{translate('African Payment Gateway Addon')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

            <!-- Website Setup -->
                @if(Auth::user()->user_type == 'admin' || in_array('13', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="website-setup-menu">
                        <a href="#" class="plx-side-nav-link {{ areActiveRoutes(['website.footer', 'website.header'])}}" >
                            <svg width="33" height="31" viewBox="0 0 33 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4631 23.9564V27.1506H24.8631V30.3448H8.86309V27.1506H15.2631V23.9564H2.4503C2.2402 23.9552 2.03241 23.9126 1.83884 23.831C1.64527 23.7494 1.46974 23.6305 1.32229 23.4811C1.17484 23.3317 1.05838 23.1548 0.979583 22.9603C0.900787 22.7659 0.861204 22.5579 0.863102 22.3482V1.60828C0.863102 0.72029 1.5911 0 2.4503 0H31.2758C32.1526 0 32.863 0.717096 32.863 1.60828V22.3482C32.863 23.2362 32.135 23.9564 31.2758 23.9564H18.4631ZM22.9317 11.8622L20.0707 14.8099L19.3556 14.0731L21.5015 11.8622L19.3556 9.65125L20.0707 8.91445L22.9317 11.8622ZM12.2241 11.8622L14.3699 14.0731L13.6548 14.8099L10.7938 11.8622L13.6548 8.91445L14.3694 9.65125L12.2241 11.8622ZM15.7441 16.5518H14.6678L17.9815 7.17251H19.0577L15.7441 16.5518ZM21.638 15.1224C21.3899 15.1466 21.1475 15.2115 20.9206 15.3146L20.9203 15.3147C20.9912 15.5554 20.9337 15.8046 20.7517 15.9441C20.5697 16.0837 20.3141 16.0751 20.0998 15.9443C19.9414 16.1369 19.8158 16.3544 19.7283 16.588C19.9487 16.708 20.084 16.925 20.0541 17.1524C20.0242 17.3796 19.8374 17.5542 19.5933 17.6132C19.6175 17.8615 19.6825 18.104 19.7857 18.3311C20.0264 18.2602 20.2755 18.3178 20.4151 18.4997C20.5547 18.6817 20.5461 18.9374 20.4153 19.1517C20.6079 19.3101 20.8254 19.4356 21.059 19.5231C21.1789 19.3028 21.396 19.1675 21.6234 19.1973C21.8505 19.2273 22.0251 19.414 22.0842 19.6582C22.3324 19.634 22.575 19.569 22.8021 19.4658C22.7312 19.2251 22.7887 18.9759 22.9707 18.8363C23.1527 18.6968 23.4083 18.7054 23.6226 18.8362C23.781 18.6435 23.9065 18.4261 23.9941 18.1925C23.7737 18.0725 23.6384 17.8554 23.6683 17.6281C23.6982 17.4009 23.885 17.2263 24.1291 17.1673C24.1049 16.919 24.0399 16.6765 23.9367 16.4494C23.696 16.5202 23.4468 16.4627 23.3073 16.2807C23.1677 16.0988 23.1763 15.8431 23.3071 15.6288C23.1145 15.4704 22.897 15.3449 22.6634 15.2573C22.5435 15.4777 22.3264 15.613 22.099 15.5831C21.8719 15.5532 21.6973 15.3664 21.638 15.1224ZM21.5194 17.9822C21.3624 17.8915 21.2479 17.7423 21.201 17.5671C21.154 17.392 21.1786 17.2055 21.2693 17.0485C21.3599 16.8915 21.5092 16.7769 21.6843 16.73C21.8594 16.6831 22.046 16.7076 22.203 16.7983C22.36 16.8889 22.4745 17.0382 22.5214 17.2133C22.5683 17.3884 22.5438 17.575 22.4531 17.732C22.3625 17.889 22.2132 18.0036 22.0381 18.0505C21.863 18.0974 21.6764 18.0728 21.5194 17.9822Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide text-nowrap">{{translate('Website Setup')}}</span>
                        </a>
                    </li>
                @endif

            <!-- Setup & Configurations -->
                @if(Auth::user()->user_type == 'admin' || in_array('14', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="configuration-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.07823 18.6073C0.791306 16.8809 0.791306 15.1191 1.07823 13.3927C2.84097 13.4343 4.42456 12.5897 5.04039 11.1037C5.65623 9.61612 5.13317 7.89819 3.8567 6.68411C4.8747 5.25936 6.12101 4.01251 7.54534 2.99391C8.76102 4.27036 10.479 4.79342 11.9666 4.17759C13.4542 3.56175 14.2972 1.97658 14.254 0.215456C15.9814 -0.0718187 17.7444 -0.0718187 19.4718 0.215456C19.4286 1.97818 20.2732 3.56175 21.7592 4.17759C23.2468 4.79342 24.9648 4.27036 26.1789 2.99391C27.6036 4.01189 28.8505 5.2582 29.8691 6.68251C28.5926 7.89819 28.0696 9.61612 28.6854 11.1037C29.3013 12.5913 30.8864 13.4343 32.6476 13.3911C32.9349 15.1185 32.9349 16.8815 32.6476 18.6089C30.8848 18.5657 29.3013 19.4103 28.6854 20.8963C28.0696 22.3839 28.5926 24.1018 29.8691 25.3159C28.8511 26.7406 27.6048 27.9875 26.1805 29.0061C24.9648 27.7296 23.2468 27.2066 21.7592 27.8224C20.2716 28.4382 19.4286 30.0234 19.4718 31.7845C17.7444 32.0718 15.9814 32.0718 14.254 31.7845C14.2972 30.0218 13.4526 28.4382 11.9666 27.8224C10.479 27.2066 8.76102 27.7296 7.54694 29.0061C6.12217 27.9881 4.87532 26.7418 3.8567 25.3175C5.13317 24.1018 5.65623 22.3839 5.04039 20.8963C4.42456 19.4087 2.83937 18.5657 1.07823 18.6089V18.6073ZM16.8629 20.7987C18.1356 20.7987 19.3562 20.2931 20.2561 19.3932C21.1561 18.4933 21.6617 17.2727 21.6617 16C21.6617 14.7273 21.1561 13.5067 20.2561 12.6068C19.3562 11.7069 18.1356 11.2013 16.8629 11.2013C15.5902 11.2013 14.3696 11.7069 13.4697 12.6068C12.5697 13.5067 12.0642 14.7273 12.0642 16C12.0642 17.2727 12.5697 18.4933 13.4697 19.3932C14.3696 20.2931 15.5902 20.7987 16.8629 20.7987V20.7987Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide text-nowrap">{{translate('Configurations')}}</span>
                        </a>
                    </li>
                @endif


            <!-- Staffs -->
                @if(Auth::user()->user_type == 'admin' || in_array('20', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="staff-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.863037 3.54667C0.863037 1.58756 2.45059 0 4.4097 0H29.3164C31.2755 0 32.863 1.58756 32.863 3.54667V28.4533C32.863 29.394 32.4894 30.2961 31.8242 30.9612C31.1591 31.6263 30.257 32 29.3164 32H4.4097C3.46907 32 2.56696 31.6263 1.90183 30.9612C1.2367 30.2961 0.863037 29.394 0.863037 28.4533V3.54667ZM6.83104 26.6667H27.2577C26.1121 25.0194 24.5849 23.6739 22.8063 22.7452C21.0278 21.8164 19.0508 21.332 17.0444 21.3333C15.0379 21.332 13.061 21.8164 11.2824 22.7452C9.50388 23.6739 7.97659 25.0194 6.83104 26.6667V26.6667ZM16.863 17.7778C17.6802 17.7778 18.4893 17.6168 19.2442 17.3041C19.9991 16.9914 20.685 16.5331 21.2628 15.9553C21.8406 15.3775 22.2989 14.6916 22.6116 13.9367C22.9243 13.1818 23.0853 12.3727 23.0853 11.5556C23.0853 10.7384 22.9243 9.92933 22.6116 9.17441C22.2989 8.4195 21.8406 7.73357 21.2628 7.15578C20.685 6.57799 19.9991 6.11967 19.2442 5.80697C18.4893 5.49428 17.6802 5.33333 16.863 5.33333C15.2128 5.33333 13.6302 5.98889 12.4633 7.15578C11.2964 8.32267 10.6408 9.90532 10.6408 11.5556C10.6408 13.2058 11.2964 14.7884 12.4633 15.9553C13.6302 17.1222 15.2128 17.7778 16.863 17.7778V17.7778Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>

                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{translate('Staffs')}}</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type == 'admin' || in_array('24', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item plx-side-nav-item-admin" id="system-menu">
                        <a href="#" class="plx-side-nav-link">
                            <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.64081 0H31.0853C31.5568 0 32.0089 0.187301 32.3423 0.520699C32.6757 0.854097 32.863 1.30628 32.863 1.77778V14.2222H0.863037V1.77778C0.863037 1.30628 1.05034 0.854097 1.38374 0.520699C1.71713 0.187301 2.16932 0 2.64081 0V0ZM0.863037 17.7778H32.863V30.2222C32.863 30.6937 32.6757 31.1459 32.3423 31.4793C32.0089 31.8127 31.5568 32 31.0853 32H2.64081C2.16932 32 1.71713 31.8127 1.38374 31.4793C1.05034 31.1459 0.863037 30.6937 0.863037 30.2222V17.7778ZM7.97415 23.1111V26.6667H13.3075V23.1111H7.97415ZM7.97415 5.33333V8.88889H13.3075V5.33333H7.97415Z" fill="#3D3D3D" fill-opacity="0.7"/>
                            </svg>
                            <span class="plx-side-nav-text plx-side-nav-text-hide">{{translate('System')}}</span>
                        </a>
                    </li>
                @endif

            <!-- Addon Manager -->
                {{--@if(Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="plx-side-nav-item">
                        <a href="{{route('addons.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['addons.index', 'addons.create'])}}">
                            <i class="las la-wrench plx-side-nav-icon"></i>
                            <span class="plx-side-nav-text">{{translate('Addon Manager')}}</span>
                        </a>
                    </li>
                @endif--}}
            </ul><!-- .plx-side-nav -->
        </div><!-- .plx-side-nav-wrap -->
        <div class="side-panel-collapse">
            <div class="plx-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-3" data-toggle="plx-mobile-nav">
                <button class="plx-mobile-toggler">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                        <path d="M6.70711 1.70711C7.09763 1.31658 7.09763 0.683418 6.70711 0.292893C6.31658 -0.0976311 5.68342 -0.0976311 5.29289 0.292893L0.292893 5.29289C-0.0976309 5.68342 -0.097631 6.31658 0.292893 6.70711L5.29289 11.7071C5.68342 12.0976 6.31658 12.0976 6.70711 11.7071C7.09763 11.3166 7.09763 10.6834 6.70711 10.2929L3.41421 7L17.0556 7C17.5772 7 18 6.55229 18 6C18 5.44772 17.5772 5 17.0556 5L3.41421 5L6.70711 1.70711Z" fill="#92278F"/>
                    </svg>
                </button>
            </div>
        </div>
    </div><!-- .plx-sidebar -->
    <div class="plx-sidebar-overlay"></div>
    <div class="d-none admin-sub-menu pos-nav-menu" id="pos-system-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{route('poin-of-sales.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['poin-of-sales.index', 'poin-of-sales.create'])}}">
                    <span class="plx-side-nav-text">{{translate('POS Manager')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('poin-of-sales.activation')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('POS Configuration')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu product-nav-menu" id="product-menu-sub">
        <!--Submenu-->
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a class="plx-side-nav-link" href="{{route('products.create')}}">
                    <span class="plx-side-nav-text">{{translate('Add New product')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('products.all')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('All Products') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('products.admin')}}" class="plx-side-nav-link {{ areActiveRoutes(['products.admin', 'products.create', 'products.admin.edit']) }}" >
                    <span class="plx-side-nav-text">{{ translate('In House Products') }}</span>
                </a>
            </li>
            @if(get_setting('vendor_system_activation') == 1)
                <li class="plx-side-nav-item">
                    <a href="{{route('products.seller')}}" class="plx-side-nav-link {{ areActiveRoutes(['products.seller', 'products.seller.edit']) }}">
                        <span class="plx-side-nav-text">{{ translate('Seller Products') }}</span>
                    </a>
                </li>
            @endif
            <li class="plx-side-nav-item">
                <a href="{{route('digitalproducts.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['digitalproducts.index', 'digitalproducts.create', 'digitalproducts.edit']) }}">
                    <span class="plx-side-nav-text">{{ translate('Digital Products') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('product_bulk_upload.index') }}" class="plx-side-nav-link" >
                    <span class="plx-side-nav-text">{{ translate('Bulk Import') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('product_bulk_export.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Bulk Export')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('categories.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Category')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('brands.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])}}" >
                    <span class="plx-side-nav-text">{{translate('Brand')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('attributes.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Attribute')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('colors')}}" class="plx-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Colors')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('reviews.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Product Reviews')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu auction-product-nav-menu" id="auction-menu-sub">
        <!--Submenu-->
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a class="plx-side-nav-link" href="{{route('auction_products.create')}}">
                    <span class="plx-side-nav-text">{{translate('Add New auction product')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('auction.all_products')}}" class="plx-side-nav-link {{ areActiveRoutes(['auction_products.edit','product_bids.show']) }}">
                    <span class="plx-side-nav-text">{{ translate('All Auction Products') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('auction.inhouse_products')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Inhouse Auction Products') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('auction.seller_products')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Seller Auction Products') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('auction_products_orders')}}" class="plx-side-nav-link {{ areActiveRoutes(['auction_products_orders.index']) }}">
                    <span class="plx-side-nav-text">{{ translate('Auction Products Orders') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu wholesale-product-nav-menu" id="wholesale-menu-sub">
        <!--Submenu-->
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a class="plx-side-nav-link" href="{{route('wholesale-products.create')}}">
                    <span class="plx-side-nav-text">{{translate('Add new wholesale product')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('wholesale-products.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['wholesale-products.edit','wholesale-products.show']) }}">
                    <span class="plx-side-nav-text">{{ translate('All wholesale products') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu sales-nav-menu" id="sale-menu-sub">
        <!--Submenu-->
        <ul class="plx-side-nav-list level-2">
            @if(Auth::user()->user_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
                <li class="plx-side-nav-item">
                    <a href="{{ route('all_orders.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['all_orders.index', 'all_orders.show'])}}">
                        <span class="plx-side-nav-text">{{translate('All Orders')}}</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->user_type == 'admin' || in_array('4', json_decode(Auth::user()->staff->role->permissions)))
                <li class="plx-side-nav-item">
                    <a href="{{ route('inhouse_orders.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['inhouse_orders.index', 'inhouse_orders.show'])}}" >
                        <span class="plx-side-nav-text">{{translate('Inhouse orders')}}</span>
                    </a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->permissions)))
                <li class="plx-side-nav-item">
                    <a href="{{ route('seller_orders.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['seller_orders.index', 'seller_orders.show'])}}">
                        <span class="plx-side-nav-text">{{translate('Seller Orders')}}</span>
                    </a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('6', json_decode(Auth::user()->staff->role->permissions)))
                <li class="plx-side-nav-item">
                    <a href="{{ route('pick_up_point.order_index') }}" class="plx-side-nav-link {{ areActiveRoutes(['pick_up_point.order_index','pick_up_point.order_show'])}}">
                        <span class="plx-side-nav-text">{{translate('Pick-up Point Order')}}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div class="admin-sub-menu delivery-boy-nav-menu" id="delivery-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{route('delivery-boys.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('All Delivery Boy')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('delivery-boys.create')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Add Delivery Boy')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('delivery-boys-payment-histories')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Payment Histories')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('delivery-boys-collection-histories')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Collected Histories')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('delivery-boy.cancel-request')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Cancel Request')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('delivery-boy-configuration')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Configuration')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu refund-nav-menu" id="refund-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{route('refund_requests_all')}}" class="plx-side-nav-link {{ areActiveRoutes(['refund_requests_all', 'reason_show'])}}">
                    <span class="plx-side-nav-text">{{translate('Refund Requests')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('paid_refund')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Approved Refunds')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('rejected_refund')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('rejected Refunds')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('refund_time_config')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Refund Configuration')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu customer-nav-menu" id="customer-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('customers.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Customer list') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu seller-nav-menu" id="seller-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                @php
                    $sellers = \App\Models\Seller::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                @endphp
                <a href="{{ route('sellers.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history','sellers.approved','sellers.profile_modal','sellers.show_verification_request'])}}">
                    <span class="plx-side-nav-text">{{ translate('All Seller') }}</span>
                    @if($sellers > 0)<span class="badge badge-info">{{ $sellers }}</span> @endif
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('sellers.payment_histories') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Payouts') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('withdraw_requests_all') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Payout Requests') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('business_settings.vendor_commission') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Seller Commission') }}</span>
                </a>
            </li>

            @if (addon_is_activated('seller_subscription'))
                <li class="plx-side-nav-item">
                    <a href="{{ route('seller_packages.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['seller_packages.index', 'seller_packages.create', 'seller_packages.edit'])}}">
                        <span class="plx-side-nav-text">{{ translate('Seller Packages') }}</span>
                        @if (env("DEMO_MODE") == "On")
                            <span class="badge badge-inline badge-danger">Addon</span>
                        @endif
                    </a>
                </li>
            @endif
            <li class="plx-side-nav-item">
                <a href="{{ route('seller_verification_form.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Seller Verification Form') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu report-nav-menu" id="report-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('in_house_sale_report.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['in_house_sale_report.index'])}}">
                    <span class="plx-side-nav-text">{{ translate('In House Product Sale') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('seller_sale_report.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['seller_sale_report.index'])}}">
                    <span class="plx-side-nav-text">{{ translate('Seller Products Sale') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('stock_report.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['stock_report.index'])}}">
                    <span class="plx-side-nav-text">{{ translate('Products Stock') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('wish_report.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['wish_report.index'])}}">
                    <span class="plx-side-nav-text">{{ translate('Products wishlist') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('user_search_report.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['user_search_report.index'])}}">
                    <span class="plx-side-nav-text">{{ translate('User Searches') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('commission-log.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Commission History') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('wallet-history.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Wallet Recharge History') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu marketing-nav-menu" id="marketing-menu-sub">
        <ul class="plx-side-nav-list level-2">
            @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                <li class="plx-side-nav-item">
                    <a href="{{ route('flash_deals.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])}}">
                        <span class="plx-side-nav-text">{{ translate('Flash deals') }}</span>
                    </a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('7', json_decode(Auth::user()->staff->role->permissions)))
            <!--<li class="plx-side-nav-item">
                                    <a href="{{route('newsletters.index')}}" class="plx-side-nav-link">
                                        <span class="plx-side-nav-text">{{ translate('Newsletters') }}</span>
                                    </a>
                                </li>-->
                @if (addon_is_activated('otp_system'))
                    <li class="plx-side-nav-item">
                        <a href="{{route('sms.index')}}" class="plx-side-nav-link">
                            <span class="plx-side-nav-text">{{ translate('Bulk SMS') }}</span>
                            @if (env("DEMO_MODE") == "On")
                                <span class="badge badge-inline badge-danger">Addon</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endif
            <li class="plx-side-nav-item">
                <a href="{{ route('subscribers.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{ translate('Subscribers') }}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('coupon.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['coupon.index','coupon.create','coupon.edit'])}}">
                    <span class="plx-side-nav-text">{{ translate('Coupon') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu support-nav-menu" id="support-menu-sub">
        <ul class="plx-side-nav-list level-2">
            @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                @php
                    $support_ticket = DB::table('tickets')
                                ->where('viewed', 0)
                                ->select('id')
                                ->count();
                @endphp
                <li class="plx-side-nav-item">
                    <a href="{{ route('support_ticket.admin_index') }}" class="plx-side-nav-link {{ areActiveRoutes(['support_ticket.admin_index', 'support_ticket.admin_show'])}}">
                        <span class="plx-side-nav-text">{{translate('Ticket')}}</span>
                        @if($support_ticket > 0)<span class="badge badge-info">{{ $support_ticket }}</span>@endif
                    </a>
                </li>
            @endif

            @php
                $conversation = \App\Models\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '1')->get();
            @endphp
            @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                <li class="plx-side-nav-item">
                    <a href="{{ route('conversations.admin_index') }}" class="plx-side-nav-link {{ areActiveRoutes(['conversations.admin_index', 'conversations.admin_show'])}}">
                        <span class="plx-side-nav-text">{{translate('Product Queries')}}</span>
                        @if (count($conversation) > 0)
                            <span class="badge badge-info">{{ count($conversation) }}</span>
                        @endif
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div class="admin-sub-menu affiliate-nav-menu" id="affiliate-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{route('affiliate.configs')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Affiliate Registration Form')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('affiliate.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Affiliate Configurations')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('affiliate.users')}}" class="plx-side-nav-link {{ areActiveRoutes(['affiliate.users', 'affiliate_users.show_verification_request', 'affiliate_user.payment_history'])}}">
                    <span class="plx-side-nav-text">{{translate('Affiliate Users')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('refferals.users')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Referral Users')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('affiliate.withdraw_requests')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Affiliate Withdraw Requests')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('affiliate.logs.admin')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Affiliate Logs')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu offline-payment-nav-menu" id="offline-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('manual_payment_methods.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['manual_payment_methods.index', 'manual_payment_methods.create', 'manual_payment_methods.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Manual Payment Methods')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('offline_wallet_recharge_request.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Offline Wallet Recharge')}}</span>
                </a>
            </li>
            @if(get_setting('classified_product') == 1)
                <li class="plx-side-nav-item">
                    <a href="{{ route('offline_customer_package_payment_request.index') }}" class="plx-side-nav-link">
                        <span class="plx-side-nav-text">{{translate('Offline Customer Package Payments')}}</span>
                    </a>
                </li>
            @endif
            @if (addon_is_activated('seller_subscription'))
                <li class="plx-side-nav-item">
                    <a href="{{ route('offline_seller_package_payment_request.index') }}" class="plx-side-nav-link">
                        <span class="plx-side-nav-text">{{translate('Offline Seller Package Payments')}}</span>
                        @if (env("DEMO_MODE") == "On")
                            <span class="badge badge-inline badge-danger">Addon</span>
                        @endif
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div class="admin-sub-menu payment-gateway-nav-menu" id="payment-gateway-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('paytm.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Set Paytm Credentials')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu club-point-nav-menu" id="club-point-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('club_points.configs') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Club Point Configurations')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('set_product_points')}}" class="plx-side-nav-link {{ areActiveRoutes(['set_product_points', 'product_club_point.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Set Product Point')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('club_points.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['club_points.index', 'club_point.details'])}}">
                    <span class="plx-side-nav-text">{{translate('User Points')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu otp-system-nav-menu" id="otp-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('otp.configconfiguration') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('OTP Configurations')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('sms-templates.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('SMS Templates')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('otp_credentials.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Set OTP Credentials')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu african-payment-nav-menu" id="african-payment-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('african.configuration') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('African PG Configurations')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('african_credentials.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Set African PG Credentials')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu website-setup-nav-menu" id="website-setup-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('website.header') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Header')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('website.footer', ['lang'=>  App::getLocale()] ) }}" class="plx-side-nav-link {{ areActiveRoutes(['website.footer'])}}">
                    <span class="plx-side-nav-text">{{translate('Footer')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('website.pages') }}" class="plx-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create' ,'custom-pages.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Pages')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('website.appearance') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Appearance')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu setup-configure-nav-menu" id="configuration-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{route('general_setting.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('General Settings')}}</span>
                </a>
            </li>

            <li class="plx-side-nav-item">
                <a href="{{route('activation.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Features activation')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('languages.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Languages')}}</span>
                </a>
            </li>

            <li class="plx-side-nav-item">
                <a href="{{route('currency.index')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Currency')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('tax.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['tax.index', 'tax.create', 'tax.store', 'tax.show', 'tax.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Vat & TAX')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('pick_up_points.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['pick_up_points.index','pick_up_points.create','pick_up_points.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Pickup point')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('smtp_settings.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('SMTP Settings')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('payment_method.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Payment Methods')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('file_system.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('File System & Cache Configuration')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{ route('social_login.index') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Social media Logins')}}</span>
                </a>
            </li>

            <li class="plx-side-nav-item">
                <a href="javascript:void(0);" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Facebook')}}</span>
                    {{--                                    <span class="plx-side-nav-arrow"></span>--}}
                </a>
                <ul class="plx-side-nav-list level-3">
                    <li class="plx-side-nav-item">
                        <a href="{{ route('facebook_chat.index') }}" class="plx-side-nav-link">
                            <span class="plx-side-nav-text">{{translate('Facebook Chat')}}</span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item">
                        <a href="{{ route('facebook-comment') }}" class="plx-side-nav-link">
                            <span class="plx-side-nav-text">{{translate('Facebook Comment')}}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="plx-side-nav-item">
                <a href="javascript:void(0);" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Google')}}</span>
                    {{--                                    <span class="plx-side-nav-arrow"></span>--}}
                </a>
                <ul class="plx-side-nav-list level-3">
                    <li class="plx-side-nav-item">
                        <a href="{{ route('google_analytics.index') }}" class="plx-side-nav-link">
                            <span class="plx-side-nav-text">{{translate('Analytics Tools')}}</span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item">
                        <a href="{{ route('google_recaptcha.index') }}" class="plx-side-nav-link">
                            <span class="plx-side-nav-text">{{translate('Google reCAPTCHA')}}</span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item">
                        <a href="{{ route('google-map.index') }}" class="plx-side-nav-link">
                            <span class="plx-side-nav-text">{{translate('Google Map')}}</span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item">
                        <a href="{{ route('google-firebase.index') }}" class="plx-side-nav-link">
                            <span class="plx-side-nav-text">{{translate('Google Firebase')}}</span>
                        </a>
                    </li>
                </ul>
            </li>




            <li class="plx-side-nav-item">
                <a href="javascript:void(0);" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Shipping')}}</span>
                    {{--                                    <span class="plx-side-nav-arrow"></span>--}}
                </a>
                <ul class="plx-side-nav-list level-3">
                    <li class="plx-side-nav-item">
                        <a href="{{route('shipping_configuration.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update'])}}">
                            <span class="plx-side-nav-text">{{translate('Shipping Configuration')}}</span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item">
                        <a href="{{route('countries.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['countries.index','countries.edit','countries.update'])}}">
                            <span class="plx-side-nav-text">{{translate('Shipping Countries')}}</span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item">
                        <a href="{{route('states.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['states.index','states.edit','states.update'])}}">
                            <span class="plx-side-nav-text">{{translate('Shipping States')}}</span>
                        </a>
                    </li>
                    <li class="plx-side-nav-item">
                        <a href="{{route('cities.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['cities.index','cities.edit','cities.update'])}}">
                            <span class="plx-side-nav-text">{{translate('Shipping Cities')}}</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
    <div class="admin-sub-menu staff-nav-menu" id="staff-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <li class="plx-side-nav-item">
                <a href="{{ route('staffs.index') }}" class="plx-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('All staffs')}}</span>
                </a>
            </li>
            <li class="plx-side-nav-item">
                <a href="{{route('roles.index')}}" class="plx-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                    <span class="plx-side-nav-text">{{translate('Staff permissions')}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-sub-menu system-nav-menu" id="system-menu-sub">
        <ul class="plx-side-nav-list level-2">
            <!-- <li class="plx-side-nav-item">
                <a href="{{ route('system_update') }}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Update')}}</span>
                </a>
            </li>-->
            <li class="plx-side-nav-item">
                <a href="{{route('system_server')}}" class="plx-side-nav-link">
                    <span class="plx-side-nav-text">{{translate('Server status')}}</span>
                </a>
            </li>
        </ul>
    </div>
</div><!-- .plx-sidebar -->
