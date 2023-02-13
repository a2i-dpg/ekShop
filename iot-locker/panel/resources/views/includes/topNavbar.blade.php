<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-end mb-0">


            <li class="dropdown d-inline-block d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light"
                    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                    aria-expanded="false">
                    <i class="fe-search noti-icon"></i>
                </a>
                <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                    <form class="p-3">
                        <input type="text" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                    </form>
                </div>
            </li>

            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen"
                    href="#">
                    <i class="fe-maximize noti-icon"></i>
                </a>
            </li>
            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                    aria-expanded="false">
                    <img src="{{ asset('') }}assets/theme/images/user-profile.png" alt="user-image"
                        class="rounded-circle">
                    <span class="pro-user-name ms-1">
                        {{ Auth()->user()->user_name }} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('common.myAccount') }}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>   
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="index.html" class="logo logo-dark text-center">
                <span class="logo-sm">
                    <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="">
                    <!-- <span class="logo-lg-text-light">UBold</span> -->
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="">
                    <!-- <span class="logo-lg-text-light">U</span> -->
                </span>
            </a>
            @if (Auth()->user()->role_id === 1)
                <a href="{{ route('superAdmin.home') }}" class="logo logo-light text-center">
                    <span class="logo-sm">
                        <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="" style="width: 80px">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="" style="width: 150px">
                    </span>
                </a> 
            @elseif(Auth()->user()->role_id == 5) <!-- 5 means agent -->
            <a href="{{ route('agent.dashboard') }}" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="" style="width: 80px">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="" style="width: 150px">
                </span>
            </a> 
            @else
            
                <a href="{{ route('admin.home') }}" class="logo logo-light text-center">
                    <span class="logo-sm">
                        <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="" style="width: 80px">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('') }}assets/theme/images/logo_dg.png" alt="" style="width: 150px">
                    </span>
                </a> 
            @endif
            
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-bs-toggle="collapse"
                    data-bs-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>