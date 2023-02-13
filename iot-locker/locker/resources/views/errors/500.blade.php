<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iotLocker</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/ekShop.ico') }}">

    <!-- icons -->
    <link href="{{ asset('') }}assets/fontawesome/css/all.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            width: 100%;
            min-height: 100vh;
            display: relative;
            margin: 0;
            padding: 0;
            background: -webkit-linear-gradient(-45deg, #183850 0, #183850 25%, #192C46 50%, #22254C 75%, #22254C 100%);
        }

        .wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            align-items: center;
            justify-content: center;
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }

        h1 {
            color: white;
            font-family: arial;
            font-weight: bold;
            line-height: 1rem;
            text-shadow: 0 0 3px white;
        }

        h4 {
            color: #f1f1f1;
            font-family: arial;
            font-weight: 300;
            font-size: 16px;
        }

        .button {
            display: block;
            margin: 20px 0 0;
            padding: 15px 30px;
            background: #22254C;
            color: white;
            font-family: arial;
            letter-spacing: 5px;
            border-radius: .4rem;
            text-decoration: none;
            box-shadow: 0 0 15px #22254C;
        }

        .cbtn {
            margin-top: 75px;
            margin-bottom: auto;
            display: inline-block;
            min-width: 300px;
            padding: 20px 0;
            background-color: orangered;
            font-family: arial;
            font-size: 25px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <img src="{{ asset('assets/images/logos/iotLocker_offline_logo.jpg') }}" alt="centered image" />
        <h1>{{__('offline.dashboard.title')}}</h1>
        <a href="{{ route('slider-page') }}" class="cbtn"><i class="fas fa-sync-alt"></i> RELOAD </a>
    </div>

    <script src="{{ asset('assets/slider-page/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function() {

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

    <script>
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
                    window.location.replace(window.location.origin);
                })
                .fail(function(data) {
                    console.log('faild');
                });
        }
    </script>
</body>



</html>