<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ env('APP_URL')}}">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
  	<title>{{ config('app.name', 'eCommerce') }}</title>

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!--plxcore css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/plx-core.css') }}">

    <script>
        var PLX = PLX|| {};
    </script>
</head>
<body>
    <div class="plx-main-wrapper d-flex">

        <div class="flex-grow-1">
            @yield('content')
        </div>

    </div><!-- .plx-main-wrapper -->
    <script src="{{ static_asset('assets/js/vendors.js') }}" ></script>
    <script src="{{ static_asset('assets/js/plx-core.js') }}" ></script>

    @yield('script')

    <script type="text/javascript">
    @foreach (session('flash_notification', collect())->toArray() as $message)
        PLX.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
    @endforeach
    </script>
</body>
</html>
