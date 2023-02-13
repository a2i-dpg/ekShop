@php
if (Session::get('show_video') != 1) {
$style = 'style=display:none';
}else {
$style = '';
}
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iotLocker</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('') }}assets/images/ekShop.ico">

    <!-- Plugins css -->
    <link href="{{ asset('') }}assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('') }}assets/css/config/creative/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('') }}assets/css/config/creative/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- <link href="{{ asset('') }}assets/css/config/creative/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" /> -->
    <link href="{{ asset('') }}assets/css/config/creative/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- Custom -->
    <link href="{{ asset('') }}assets/css/custom-style.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />
    <link href="{{ asset('') }}assets/css/custom-style-media.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- Keyboard -->
    <link href="{{ asset('') }}assets/keyboard/css/jkeyboard.css" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/toastr/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('custom-css')

    @if(Session::get('locale') == 'bn')
    <style>
        @font-face {
            font-family: SolaimanLipi;
            src: url("{{ asset('assets/fonts/SolaimanLipi_22-02-2012.ttf') }}");
        }

        body {
            font-family: "SolaimanLipi" !important;
        }
    </style>
    @endif

</head>

<!-- body start -->

<body data-layout-mode="horizontal" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <div class="help-btn-master" {{ $style }}>
        <a href="#" class="btn btn-lg p-0" role="button" title="{{__('master-app.button.help.title')}}" tabindex="0" data-plugin="tippy" data-tippy-touchHold="true" onclick="showHelpVideo()"><i class="fas fa-info-circle"></i></a>
    </div>

    <div class="">
        <!-- Begin page -->
        <!-- <div id="wrapper" class="@yield('home-bg')" style="display: flex; align-items:center"> -->
        <div id="wrapper" class="@yield('home-bg')">

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <!-- <div class="content-page" style="flex: 1;"> -->
            <div class="content-page">
                <div class="content">
                    @yield('content')
                </div>

                <!-- Info Alert Modal -->
                <div id="info-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <!-- <i class="dripicons-information h1 text-info"></i> -->
                                    <h3 class="mt-2 text-danger">{{__('master-app.modal.time-up.title')}}</h3>
                                    <h5 class="my-3">{{__('master-app.modal.time-up.sub-title')}}</h5>
                                    <button type="button" class="btn btn-lg btn-info mx-2 px-5" style="background-color: orangered;" data-bs-dismiss="modal" onclick="decreaseIdelTime(this)">{{__('master-app.modal.time-up.button-label')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Info Alert Modal -->

                <!-- offline Alert Modal -->
                <div id="offline-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <h3 class="mt-2 text-danger">{{__('master-app.modal.offline-alert.title')}}</h3>
                                    <h5 class="my-3">{{__('master-app.modal.offline-alert.sub-title')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End offline Alert Modal -->

                <!-- Start Help video Modal Modal -->
                <div id="help-video-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="false">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-1" style="background-color:#F8E86B;">
                                <h4 class="modal-title" id="standard-modalLabel">{{__('master-app.modal.help-video.title')}}</h4>
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            </div>
                            <div class="modal-body p-0" style="height:75vh">
                                <!-- <iframe id="iframeiotLockerVideo" src="#" frameborder="0" allowfullscreen style="width: 100%; height:75vh"></iframe> -->
                            </div>
                            <div class="modal-footer p-0" style="background-color:#F8E86B;">
                                <button type="button" class="btn btn-md btn-light text-white px-4" data-bs-dismiss="modal" aria-label="Close" onclick="stopVideo()" style="background-color: orangered; border:0;">{{__('master-app.modal.help-video.button-label')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Help video Modal -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->
    </div>

    <!-- Vendor js -->
    <script src="{{ asset('') }}assets/js/vendor.min.js"></script>

    <!-- Plugins js-->
    <script src="{{ asset('') }}assets/libs/flatpickr/flatpickr.min.js"></script>
    {{-- <script src="{{ asset('') }}assets/libs/apexcharts/apexcharts.min.js"></script> --}}

    <script src="{{ asset('') }}assets/libs/selectize/js/standalone/selectize.min.js"></script>

    <!-- Dashboar 1 init js-->
    {{-- <script src="{{ asset('') }}assets/js/pages/dashboard-1.init.js"></script> --}}

    <!-- Tippy js-->
    <script src="{{ asset('') }}assets/libs/tippy.js/tippy.all.min.js"></script>

    <!-- App js-->
    <script src="{{ asset('') }}assets/js/app.min.js"></script>
    <script src="{{ asset('') }}assets/js/jquery.min.js"></script>

    <!-- Keyboard js-->
    <script src="{{ asset('') }}assets/keyboard/js/jkeyboard.js"></script>

    <!-- Toastr js-->
    <script src="{{ asset('') }}assets/toastr/toastr.min.js"></script>

    @if(env('CU_VERSION') === '2')

    <!-- WebSocket integration - v2 -->

    @else

    <!-- WebSocket integration - v3 -->

    @endif

    <script>
        toastr.options = {
            "positionClass": 'toast-top-left'
        }
    </script>

    <script>
        var x = document.getElementsByTagName("BODY")[0];
        x.style.visibility = 'visible';
        x.style.opacity = '1';
    </script>
    <script>
        // $(window).load('load', function() {
        //     $('.loader').fadeOut(1000);
        //     $('.content_data').fadeIn(1000);
        // });
    </script>

    <script type="text/javascript">
        var offlineTimeout;
        var idleTime = 0;
        var clearTimeOutRedirect;
        var form = document.getElementById('logout-form');
        var sessionLifeTime = 2;

        // sessionLifeTime = parseInt("{{ config('session.lifetime') }}");
        sessionLifeTime = parseInt("{{ Session::get('session_time') }}");

        $(document).ready(function() {

            //Touch zoom off
            document.addEventListener('touchmove', e => {
                if (e.touches.length > 1) {
                    e.preventDefault();
                }
            }, {
                passive: false
            });

            // window.history.forward();
            $('#info-alert-modal').modal({
                backdrop: 'static',
                keyboard: false
            });

            $('#offline-alert-modal').modal({
                backdrop: 'static',
                keyboard: false
            });

            $('#help-video-modal').modal({
                backdrop: 'static',
                keyboard: false
            });

            // Prevent cut, copy & paste
            $('body').bind('cut copy paste', function(e) {
                e.preventDefault();
            });

            // Prevent mouse right menu
            $('body').on('contextmenu', function(e) {
                return false;
            });

            // Increment the idle time counter every minute.
            var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
            // var idleInterval = setInterval(timerIncrement, 59000); // 1 minute(59 seconds for confirmation before server timeout)
            // var idleInterval = setInterval(timerIncrement, 5000); //this is for test purpose

            // Zero the idle timer on mouse movement.
            $(this).mousemove(function(e) {
                idleTime = 0;
                clearInterval(idleInterval);
                idleInterval = setInterval(timerIncrement, 60000);
            });

            $(this).keypress(function(e) {
                idleTime = 0;
                clearInterval(idleInterval);
                idleInterval = setInterval(timerIncrement, 60000);
            });

            $(this).on('touchstart', function() {
                idleTime = 0;
                clearInterval(idleInterval);
                idleInterval = setInterval(timerIncrement, 60000);
            });

            $("#help-video-modal").on('hidden.bs.modal', function(e) {
                $("#help-video-modal iframe").attr("src", $("#help-video-modal iframe").attr("src"));
            });
        });

        function timerIncrement() {
            idleTime = idleTime + 1;

            if (sessionLifeTime != null && idleTime >= sessionLifeTime) {
                $('#info-alert-modal').modal('show');
                clearTimeOutRedirect = setTimeout(timeOutRedirect, 30000);
            }
        }

        function timeOutRedirect() {
            if (form != null) {
                form.submit();
            } else {
                window.location.replace(window.location.origin);
            }
        }

        function decreaseIdelTime(e) {
            idleTime = 0;
            clearTimeout(clearTimeOutRedirect);
        }

        setInterval(function() {
            checkInternet();
        }, 1000 * 10);

        function checkInternet() {
            var resource = '/check-internet-hb';
            var apiEndpoint = "{{env('API_BASE_URL')}}" + "{{env('API_VERSION')}}" + resource;

            $.ajax({
                    type: 'GET',
                    dataType: "json",
                    url: apiEndpoint,
                    timeout: 2000,
                    retries: 1,
                    headers: {
                        "appKey": "{{env('APP_KEY')}}",
                        "clientSecret": "{{Session::get('clientSecret')}}",
                        "client": "{{Session::get('client')}}",
                        "locationId": "{{Session::get('locationId')}}"
                    }
                })
                .done(function(data) {
                    // clearTimeout(offlineTimeout);
                    // $('#offline-alert-modal').modal('hide');
                    console.log('Remote connection successful');
                })
                .fail(function(data) {
                    console.log('Remote connection failed');

                    // $('#offline-alert-modal').modal('show');
                    // offlineTimeout = setTimeout(function() {
                    //     window.location.replace(window.location.origin + '/offline');
                    // }, 10000);
                });
        }

        function showHelpVideo() {
            var iframe = document.getElementById("iframeiotLockerVideo");
            iframe.src = "{{ asset('assets/videos/demo-video.mp4') }}";

            $('#help-video-modal').modal('show');
        }

        function stopVideo() {
            var iframe = document.getElementById("iframeiotLockerVideo");
            iframe.src = '#';
        }
    </script>

    @yield('custom-js')

    <!-- Code for Toastr -->
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
        toastr.error("{!! $error !!}");
    </script>
    @endforeach
    @endif

    @if (session('success'))
    <script>
        toastr.success("{!! session('success') !!}");
    </script>
    @endif

    @if (session('error'))
    <script>
        toastr.error("{!! session('error') !!}");
    </script>
    @endif
</body>

</html>