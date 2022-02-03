<!doctype html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @else
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        @endif
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="app-url" content="{{ getBaseURL() }}">
            <meta name="file-base-url" content="{{ getFileBaseURL() }}">

            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Favicon -->
            <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
            <title>{{ get_setting('website_name').' | '.get_setting('site_motto') }}</title>

            <!-- google font -->
            <link
                href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
                rel="stylesheet">

            <!--plxcore css -->
            <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
            @if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
                <link rel="stylesheet" href="{{ static_asset('assets/css/bootstrap-rtl.min.css') }}">
            @endif
            <link rel="stylesheet" href="{{ static_asset('assets/css/plx-core.css') }}">

            <style>
                body {
                    font-size: 12px;
                }
            </style>
            <script>
                var PLX = PLX|| {};
                PLX.local = {
                    nothing_selected: '{{ translate('Nothing selected') }}',
                    nothing_found: '{{ translate('Nothing found') }}',
                    choose_file: '{{ translate('Choose file') }}',
                    file_selected: '{{ translate('File selected') }}',
                    files_selected: '{{ translate('Files selected') }}',
                    add_more_files: '{{ translate('Add more files') }}',
                    adding_more_files: '{{ translate('Adding more files') }}',
                    drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
                    browse: '{{ translate('Browse') }}',
                    upload_complete: '{{ translate('Upload complete') }}',
                    upload_paused: '{{ translate('Upload paused') }}',
                    resume_upload: '{{ translate('Resume upload') }}',
                    pause_upload: '{{ translate('Pause upload') }}',
                    retry_upload: '{{ translate('Retry upload') }}',
                    cancel_upload: '{{ translate('Cancel upload') }}',
                    uploading: '{{ translate('Uploading') }}',
                    processing: '{{ translate('Processing') }}',
                    complete: '{{ translate('Complete') }}',
                    file: '{{ translate('File') }}',
                    files: '{{ translate('Files') }}',
                }
            </script>

        </head>
        <body class="bg-base">

        <div class="plx-main-wrapper">
            @include('admin.inc.admin_sidenav')
            <div class="plx-content-wrapper">
                @include('admin.inc.admin_nav')
                <div class="plx-main-content">
                    <div class="px-5percent px-lg-10percent">
                        @yield('content')
                    </div>
                    <div class="text-center py-3 px-15px px-lg-25px mt-auto">
                        <p class="mb-0 fs-14">&copy; {{ get_setting('site_name') }}
                            v{{ get_setting('current_version') }}</p>
                    </div>
                </div><!-- .plx-main-content -->
            </div><!-- .plx-content-wrapper -->
        </div><!-- .plx-main-wrapper -->

        @yield('modal')


        <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
        <script src="{{ static_asset('assets/js/plx-core.js') }}"></script>

        @yield('script')

        <script type="text/javascript">
            @foreach (session('flash_notification', collect())->toArray() as $message)
            PLX.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
            @endforeach


            if ($('#lang-change').length > 0) {
                $('#lang-change .dropdown-menu a').each(function () {
                    $(this).on('click', function (e) {
                        e.preventDefault();
                        var $this = $(this);
                        var locale = $this.data('flag');
                        $.post('{{ route('language.change') }}', {
                            _token: '{{ csrf_token() }}',
                            locale: locale
                        }, function (data) {
                            location.reload();
                        });

                    });
                });
            }

            function menuSearch() {
                var filter, item;
                filter = $("#menu-search").val().toUpperCase();
                items = $("#main-menu").find("a");
                items = items.filter(function (i, item) {
                    if ($(item).find(".plx-side-nav-text")[0].innerText.toUpperCase().indexOf(filter) > -1 && $(item).attr('href') !== '#') {
                        return item;
                    }
                });

                if (filter !== '') {
                    $("#main-menu").addClass('d-none');
                    $("#search-menu").html('')
                    if (items.length > 0) {
                        for (i = 0; i < items.length; i++) {
                            const text = $(items[i]).find(".plx-side-nav-text")[0].innerText;
                            const link = $(items[i]).attr('href');
                            $("#search-menu").append(`<li class="plx-side-nav-item"><a href="${link}" class="plx-side-nav-link"><i class="las la-ellipsis-h plx-side-nav-icon"></i><span>${text}</span></a></li`);
                        }
                    } else {
                        $("#search-menu").html(`<li class="plx-side-nav-item">
					<span class="text-center text-muted d-block">{{ translate('Nothing Found') }}</span></li>`);
                    }
                } else {
                    $("#main-menu").removeClass('d-none');
                    $("#search-menu").html('')
                }
            }
        </script>
        <script>
            $(document).ready(function () {
                let mouse_is_inside = false;
                let last_click = '';
                $("#main-menu").on("click", "li", function () {
                    let current_click = $(this).attr('id')
                    $('.admin-sub-menu').hide();
                    if (current_click === last_click) {
                        if (!mouse_is_inside) {
                            $(`#${$(this).attr('id')}-sub`).show();
                        }
                        mouse_is_inside = !mouse_is_inside;
                    } else {
                        $(`#${$(this).attr('id')}-sub`).show();
                        mouse_is_inside = true;
                    }
                    last_click = current_click;
                    $(this).children(".plx-side-nav-link").find('.plx-side-nav-text').toggleClass('text-base');
                });

                $(document).mouseup(function (e) {
                    let container = $("#main-menu");
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        $('.admin-sub-menu').hide();
                        mouse_is_inside = false;
                    }
                });
            });

        </script>

        </body>
        </html>
