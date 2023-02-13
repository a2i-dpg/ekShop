@includeIf('includes.dashboard_head')

<!-- body start -->

<body class="" id="body" data-sidebar-size="condensed" data-size="100">
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        @includeIf('includes.topNavbar')
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-sidebar">
            @auth
                @if (Auth::user()->role->role_slug === 'super-admin')
                    @includeIf('includes.sideNav')
                @endif
                @if (Auth::user()->role->role_slug === 'company-admin')
                    @includeIf('includes.company_sideNav')
                @endif
                @if (Auth::user()->role->role_slug === 'company-agent')
                    @includeIf('includes.company_agent_sideNav')
                @endif
                @if (Auth::user()->role->role_slug === 'locker-master')
                    @includeIf('includes.locker_master_sideNav')
                @endif
            @endauth
        </div>
        <!-- Left Sidebar End -->


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <i class="fe-filter location_filter_icon" id="location_filter_icon" onclick="showHideLocation()"></i>

            <div class="content">
                <!-- Start Content-->
                <div class="">
                    @yield('content')
                </div> <!-- container -->
            </div> <!-- content -->

            <!-- Footer Start -->
            @includeIf('includes.footer')
            <!-- end Footer -->
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <script src="{{ asset('') }}assets/theme/js/jquery.min.js"></script>
    <!-- Vendor js -->
    <script src="{{ asset('') }}assets/theme/js/vendor.min.js"></script>
    <script src="{{ asset('') }}assets/theme/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}assets/common/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}assets/theme/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('') }}assets/common/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('') }}assets/common/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> --}}
    {{-- Toastr js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Plugins js-->
    <script src="{{ asset('') }}assets/theme/js/flatpickr.min.js"></script>
    {{-- <script src="{{ asset('') }}assets/theme/js/apexcharts.min.js"></script> --}}

    {{-- <script src="{{ asset('') }}assets/theme/js/selectize.min.js"></script> --}}
    <!-- Tippy js-->
    <script src="{{ asset('') }}assets/theme/js/tippy.all.min.js"></script>
    <!-- Dashboar 1 init js-->
    {{-- <script src="{{ asset('') }}assets/theme/js/dashboard-1.init.js"></script> --}}

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- App js-->
    <script src="{{ asset('') }}assets/theme/js/app.js"></script>
    @livewireScripts
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success("{{ Session::get('message') }}");
            // toastr.danger("{{ Session::get('message') }}");
        </script>
    @endif

    <script>
        $(document).ready(function() {

            var body = document.getElementById('body');
            body.setAttribute('data-sidebar-size', 'condensed');
            // setTimeout(() => {
            //     console.log("ready sidebar");
            // }, 1000);


        });
    </script>

    {{-- Page Custom Script --}}
    @yield('custom_script')

</body>

</html>
