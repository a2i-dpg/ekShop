<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>iotLocker | ekShop Service</title>
    {{-- <meta name="viewport" content= "width=device-width, user-scalable=no"> --}}
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">
    <!-- third party css -->
    <link href="{{ asset('') }}assets/theme/css/bootstrap.min.css" rel="stylesheet" type="text/css"
        id="bs-default-stylesheet" />

    <link href="{{ asset('') }}assets/theme/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800&display=swap"
        rel="stylesheet">
    <!-- third party css end -->
    <!-- Plugins css -->
    <link href="{{ asset('') }}assets/theme/css/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/theme/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('') }}assets/common/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/common/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
    <link href="{{ asset('') }}assets/theme/css/tippy.css" rel="stylesheet" type="text/css"
        id="app-default-stylesheet" />
    <link href="{{ asset('') }}assets/theme/css/app.css" rel="stylesheet" type="text/css"
        id="app-default-stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/theme/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css"
        id="bs-dark-stylesheet" />
    <link href="{{ asset('') }}assets/theme/css/app-dark.min.css" rel="stylesheet" type="text/css"
        id="app-dark-stylesheet" />

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('') }}assets/common/css/master_layout_v02.css">
    <!-- icons -->
    <link href="{{ asset('') }}assets/theme/css/icons.min.css" rel="stylesheet" type="text/css" />

    {{-- For Daterange: works --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    {{-- For Date Range Pick --}}
    <script src="{{ asset('') }}assets/theme/js/jquery.min.js"></script>
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> --}}

    
    @livewireStyles

    <style>
        .js-location-select2 + .select2 .select2-selection{
            height: 100%;
            display: flex;
            align-items: center;
            border-radius: 0 5px 5px 0;
        }

        body{
            /* background: red; */
        }
    </style>

    @yield('custom_css')
</head>
