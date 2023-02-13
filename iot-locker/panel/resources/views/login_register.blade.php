<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>iotLocker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('') }}assets/theme/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('') }}assets/theme/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('') }}assets/theme/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('') }}assets/theme/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('') }}assets/theme/css/icons.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('') }}assets/common/css/login.css">
    @livewireStyles
</head>

<body>
    <div class="overlay"></div>
    <div class="video_wrap">
        {{-- <video autoplay="" muted="" loop="" id="myVideo">
            <source src="{{asset('/assets/videos/iotLocker_video.webm')}}" type="video/webm">
        </video> --}}
    </div>
    <div class="account-pages" style="margin-top:0;margin-bottom:0;display:flex;justify-content:center;align-items:center; min-height:100vh">
        <div class="container">
            <div class="row justify-content-center">
                <div class="logo">
                    <img src="{{asset('/assets/images/ekshop-logo-dpg.png')}}" alt="iotLocker Logo">
                </div>
                <div class="col-md-4">
                    <div class="card">
                        @yield('content')
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        <p>
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script>
            <strong>a2i dpg.</strong> All Right Reserved
        </p>
        <a href="https://a2i.gov.bd/" target="_blank" class="text-white-50">www.a2i.gov.bd</a>
    </footer>

    <!-- Vendor js -->
    <script src="{{ asset('') }}assets/theme/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{ asset('') }}assets/theme/js/app.min.js"></script>
    <script>
        let eyebtn = document.getElementById('passEye');
        let passField = document.getElementById('password');
        eyebtn.addEventListener('click', () => {
            if (passField.type === "password") {
                passField.type = "text";
            } else {
                passField.type = "password";
            }
        });
    </script>
    @livewireScripts
</body>

</html>