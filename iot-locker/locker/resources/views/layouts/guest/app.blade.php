<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>iotLocker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('') }}assets/images/ekShop.ico">

    <!-- Plugins css -->
    <link href="{{ asset('') }}assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('') }}assets/css/config/creative/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('') }}assets/css/config/creative/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('') }}assets/css/config/creative/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('') }}assets/css/config/creative/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- Custom -->
    <link href="{{ asset('') }}assets/css/custom-style.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- Keyboard -->
    <link href="{{ asset('') }}assets/keyboard/css/jkeyboard.css" rel="stylesheet">

</head>

<!-- body start -->

<body class="loading" data-layout-mode="horizontal" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <!-- <div id="loader">
        <img src="{{ asset('') }}assets/images/loader.gif" alt="">
    </div> -->

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Start Topbar -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-end mb-0">
                    <li class="dropdown d-none d-lg-inline-block topbar-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('') }}assets/images/flags/us.jpg" alt="user-image" height="16">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="{{ asset('') }}assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="{{ asset('') }}assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="{{ asset('') }}assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="{{ asset('') }}assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                            </a>

                        </div>
                    </li>
                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="#" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <!-- <img src="{{ asset('') }}assets/images/logo-sm.png" alt="" height="22"> -->
                            <span class="logo-lg-text-light">iotLocker</span>
                        </span>
                        <span class="logo-lg">
                            <!-- <img src="{{ asset('') }}assets/images/logo-dark.png" alt="" height="20"> -->
                            <span class="logo-lg-text-light">iotLocker</span>
                        </span>
                    </a>

                    <a href="#" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <!-- <img src="{{ asset('') }}assets/images/logo-sm.png" alt="" height="22"> -->
                            <span class="logo-lg-text-light">iotLocker</span>
                        </span>
                        <span class="logo-lg">
                            <!-- <img src="{{ asset('') }}assets/images/logo-light.png" alt="" height="20"> -->
                            <span class="logo-lg-text-light">iotLocker</span>
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
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
        <!-- End Topbar -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> &copy; iotLocker developed by <a href="http://ekshop.gov.bd/" target="_blank">ekShop</a>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">About Us</a>
                            <a href="javascript:void(0);">Help</a>
                            <a href="javascript:void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="{{ asset('') }}assets/js/vendor.min.js"></script>

    <!-- Plugins js-->
    <script src="{{ asset('') }}assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('') }}assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="{{ asset('') }}assets/libs/selectize/js/standalone/selectize.min.js"></script>

    <!-- Dashboar 1 init js-->
    <script src="{{ asset('') }}assets/js/pages/dashboard-1.init.js"></script>

    <!-- App js-->
    <script src="{{ asset('') }}assets/js/app.min.js"></script>

    <!-- Keyboard js-->
    <script src="{{ asset('') }}assets/keyboard/js/jkeyboard.js"></script>

    <script>
        var loader = document.getElementById('loader');
        // window.addEventListener("load", function() {
        //     loader.style.display = "none";
        // })
        const myTimeout = setTimeout(function() {
            loader.style.display = "none";
        }, 1500);
    </script>
</body>

</html>