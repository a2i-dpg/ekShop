<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>IOT Locker | a2i DPG Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    {{-- <link href="{{ asset('') }}assets/theme/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css"
        id="bs-dark-stylesheet" /> --}}
    <link href="{{ asset('') }}assets/theme/css/app-dark.min.css" rel="stylesheet" type="text/css"
        id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('') }}assets/theme/css/icons.min.css" rel="stylesheet" type="text/css" />

    {{-- Date Range --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        small,
        strong,
        button,
        body {
            font-family: 'Nunito Sans', sans-serif !important;
        }

        .dt-buttons {
            column-gap: 5px;
            padding-top: 15px
        }

        .dt-buttons button {
            padding: 5px 12px !important;
            background: blueviolet !important;
            color: #fff !important;
            border-radius: 0px !important;
            outline: none !important;
            border: none !important;

        }

    </style>

    <link rel="stylesheet" href="{{ asset('') }}assets/common/css/report_dashboard.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/common/css/report_dashboard_responsive.css">


    @livewireStyles
</head>
