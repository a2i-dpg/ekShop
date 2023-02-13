<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>iotLocker</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/ekShop.ico') }}">

    <link href="{{ asset('assets/slider-page/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/slider-page/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/slider-page/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('assets/slider-page/nunito_sans/NunitoSans-Bold.ttf') }}" rel="stylesheet" type="text/css" /> -->

    <style>
        @font-face {
            font-family: nunitosans;
            src: url("{{ asset('assets/slider-page/nunito_sans/NunitoSans-Bold.ttf') }}");
        }

        html,
        body {
            height: 100%;
        }

        .carousel,
        .item,
        .active {
            height: 100%;
        }

        .carousel-inner {
            height: 100%;
            background: #000;
        }

        .carousel-caption {
            padding-bottom: 80px;
        }

        .carousel-caption .btn:hover {
            /* text-shadow: none; */
            color: white !important;
        }

        h2 {
            font-size: 60px;
        }

        p {
            padding: 10px;
        }

        /* Background images are set within the HTML using inline CSS, not here */

        .fill {
            width: 100%;
            height: 100%;
            background-position: center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
            /* opacity: 0.6; */
        }

        /**
            * Button
            */
        .btn-transparent {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-transparent:hover {
            background-color: #fff;
        }

        .btn-rounded {
            border-radius: 70px;
        }

        .btn-large {
            padding: 14px 119px;
            font-size: 30px;
            /* background: #ffffff57; */
            background: rgba(255, 68, 0, 0.493);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8.8px);
            -webkit-backdrop-filter: blur(8.8px);
            border: 1px solid orangered;
            color: white !important;
        }

        /**
            * Change animation duration
            */
        .animated {
            -webkit-animation-duration: 0.5s;
            animation-duration: 0.5s;
        }

        .animated :hover {
            background-color: orangered;
            border: none;
            color: #fff;
        }

        @-webkit-keyframes fadeInRight {
            from {
                opacity: 0;
                -webkit-transform: translate3d(100px, 0, 0);
                transform: translate3d(100px, 0, 0);
            }

            to {
                opacity: 1;
                -webkit-transform: none;
                transform: none;
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                -webkit-transform: translate3d(100px, 0, 0);
                transform: translate3d(100px, 0, 0);
            }

            to {
                opacity: 1;
                -webkit-transform: none;
                transform: none;
            }
        }

        .fadeInRight {
            -webkit-animation-name: fadeInRight;
            animation-name: fadeInRight;
        }

        /* Start Design for offline Modal */
        .modal {
            position: fixed !important;
            top: 0;
            left: 0;
            z-index: 1055 !important;
            display: none;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            outline: 0;
        }

        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 1rem;
        }

        .modal-content {
            position: relative !important;
            display: flex !important;
            flex-direction: column !important;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 0 solid transparent;
            border-radius: 0.2rem;
            outline: 0;
        }

        .modal h3,
        .modal h5 {
            font-family: 'nunitosans', sans-serif !important;
            line-height: 3rem !important;
        }

        .modal.show .modal-dialog {
            transform: none;
        }

        .modal.fade .modal-dialog {
            transition: transform .3s ease-out;
            transform: translate(0, 0px);
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: 0.5rem;
            pointer-events: none;
        }

        @media (min-width: 576px) {
            .modal-dialog-centered {
                min-height: calc(100% - 3.5rem);
            }

            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto;
            }
        }

        .p-4 {
            padding: 40px !important;
        }

        .mt-2 {
            margin-top: 0.75rem !important;
        }

        .my-3 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .text-danger {
            --bs-text-opacity: 1;
            color: rgba(248, 98, 98, var(--bs-text-opacity)) !important;
        }

        .fade {
            transition: opacity .15s linear;
        }

        /* End Design for offline Modal */
    </style>
</head>

<body>
    <!-- Full Page Image Background Carousel Header -->
    <div id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            @if(!isset($sliders))

            <div class="item active">
                <div class="fill" style="background-image: url('assets/images/slider/slider_6.jpeg')"></div>
                <div class="carousel-caption">
                    <p class="animated fadeInUp">
                        <a href="{{ route('fend.dashboard') }}" class="btn btn-rounded btn-large">START</a>
                    </p>
                </div>
            </div>
            @else
            @foreach ($sliders as $key => $slider)

            @php
            $image = asset('storage/sliders/' . $slider);
            $active = ($key == 0 ? 'active' : '');
            @endphp

            <div class="item {{ $active }}">
                <div class="fill" style="background: url({{$image}})"></div>
                <div class="carousel-caption">
                    <p class="animated fadeInUp">
                        <a href="{{ route('fend.dashboard') }}" class="btn btn-rounded btn-large">START</a>
                    </p>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev" id="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next" id="next">
            <span class="icon-next"></span>
        </a>
    </div>

    <!-- offline Alert Modal -->
    <div id="offline-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <h3 class="mt-2 text-danger">Alert message!</h3>
                        <h5 class="my-3">System going to be offline...!</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End offline Alert Modal -->

    <script src="{{ asset('assets/slider-page/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/slider-page/bootstrap.min.js') }}"></script>

    @if(env('CU_VERSION') === '2')

    <!-- WebSocket integration - v2 -->

    @else

    <!-- WebSocket integration - v3 -->

    @endif

    <script>
        setInterval(() => {
            $("#next").click();
        }, 20000);
    </script>

    <script>
        $(document).ready(function() {
            window.localStorage.removeItem("activeTab_pickup");

            //Touch zoom off
            document.addEventListener('touchmove', e => {
                if (e.touches.length > 1) {
                    e.preventDefault();
                }
            }, {
                passive: false
            });

            // Prevent cut, copy & paste
            $('body').bind('cut copy paste', function(e) {
                e.preventDefault();
            });

            // Prevent mouse right menu
            $('body').on('contextmenu', function(e) {
                return false;
            });
        });
    </script>


    <!-- Touch -->
    <script>
        document.addEventListener('touchstart', handleTouchStart, false);
        document.addEventListener('touchmove', handleTouchMove, false);

        var xDown = null;
        var yDown = null;

        function getTouches(evt) {
            return evt.touches || // browser API
                evt.originalEvent.touches; // jQuery
        }

        function handleTouchStart(evt) {
            const firstTouch = getTouches(evt)[0];
            xDown = firstTouch.clientX;
            yDown = firstTouch.clientY;
        };

        function handleTouchMove(evt) {
            if (!xDown || !yDown) {
                return;
            }

            var xUp = evt.touches[0].clientX;
            var yUp = evt.touches[0].clientY;

            var xDiff = xDown - xUp;
            var yDiff = yDown - yUp;

            if (Math.abs(xDiff) > Math.abs(yDiff)) {
                /*most significant*/
                if (xDiff > 0) {
                    /* left swipe */
                    // console.log("left");
                    $("#next").click();
                } else {
                    /* right swipe */
                    // console.log("right");
                    $("#prev").click();
                }
            } else {
                if (yDiff > 0) {
                    /* up swipe */
                    // console.log("Up");

                } else {
                    /* down swipe */
                    // console.log("Down");
                    window.location.reload();
                }
            }
            /* reset values */
            xDown = null;
            yDown = null;
        };
    </script>

    <script>
        var offlineTimeout;
        var serverMessage;
        var socket;

        const webSocketEndpoint = "{{ env('WEB_SOCKET_URL') }}" + ":" + "{{ env('WEB_SOCKET_URL_PORT') }}";

        function reloadPage() {
            window.location.reload();
        }

        function connect() {
            socket = new Locker(webSocketEndpoint, CUV2);
        }
        connect();

        socket.onOpen(() => {
            console.log('Connection Ready\n');

            var BoxOpenSetInterval = setInterval(() => {
                getBoxStatus(`STA`, function(status) {
                    updateBoxCloseStatus(status);
                });
            }, 60000 * 5);
        });

        socket.onClose(() => {
            console.log('Connection Closed\n');
            reloadPage();
        });

        socket.onMessage((d) => {
            boxStatusArray.push(d.locked);
        });

        //Get Boxes Status - with a callback function
        function getBoxStatus(cmd, callBack) {
            boxStatus = [];
            boxStatusArray = [];

            socket.send("STA");

            setTimeout(function() {
                boxStatusArray.forEach(element => {
                    boxStatus = boxStatus.concat(element);
                });

                callBack(boxStatus);

            }, 200);
        }

        function updateBoxCloseStatus(allBoxStatus) {
            let resource = '/update-box-is-closed';
            let urlEndpoint = window.location.origin + resource;

            $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: urlEndpoint,
                    timeout: 2000,
                    retries: 1,
                    headers: {
                        "appKey": "{{ env('APP_KEY') }}",
                        "secretKey": 'secretKey',
                    },
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "all_box_status": allBoxStatus
                    },
                })
                .done(function(data) {
                    console.log(data);
                    console.log('update-box-is-closed Done Block');
                })
                .fail(function(data) {
                    console.log(data);
                    console.log('update-box-is-closed Faild Block');
                });
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
    </script>
</body>

</html>