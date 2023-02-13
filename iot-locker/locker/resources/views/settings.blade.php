@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

<style>
    /* .right_side_box{
        height: 88vh !important;
        width: 60vw !important;
    } */
    #search_location{
        height: 80vh;
    }
</style>

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-6">
                            <a href="{{route('fend.dashboard')}}" class="btn btn-lg win7-btn back-btn btn-block" role="button"> Back </a>
                        </div>
                        <div class="col-sm-6" style="text-align:right">
                            <a href="{{route('logout')}}" class="btn btn-lg logout_btn win7-btn " role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- tasks panel -->
    {{-- <div class="row justify-content-md-center">
        <div class="col-xl-9 col-md-9">
            <div class="row">
                <div class="col">
                    
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            
        </div>
    </div> --}}

    <div class="content-conainer">
        <div class="right_side_box">
            {{-- Locker Search --}}
            <div class="card" id="search_location">
                <div class="card-body">
                    <div id="error_message" class="alert alert-danger" role="alert" style="display: none;">
                    </div>

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Initial setup for location</h4>
                            @if ($errors->any())
                            <div class="alert alert-danger server_error_message">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <hr class="my-2" />
                            <div class="row justify-content-md-center">
                                <div class="col-md-8 my-2">
                                    <form method="" action="">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="location_id" class="form-label">Location ID</label>
                                            <input class="form-control" type="text" id="location_id" name="location_id" placeholder="Enter location id" onfocus="myKeyboard(this)" autocomplete="off">
                                        </div>
                                        <div class="row align-items-center">
                                            <label for="parcel_number" class="form-label">Location Credentials</label>
                                            <div class="col-xl-6 col-md-6">
                                                <input class="form-control mb-2" type="text" id="client_name" name="client_name" placeholder="Client name" onfocus="myKeyboard(this)" autocomplete="off">
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="input-group mb-2">
                                                    <input class="form-control" type="text" id="client_secret" name="client_secret" placeholder="Client Secret" onfocus="myKeyboard(this)" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center d-grid">
                                            <button class="btn win7-btn btn-lg" id="search" type="submit"> Search </button>
                                        </div>
                                    </form>
                                </div>
                                <div id="keyboard_location_id"></div>
                                <div id="keyboard_client_name"></div>
                                <div id="keyboard_client_secret"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Locker Information --}}
            <div class="card" id="display_location" style="display: none;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Location Information</h4>
                            <hr class="my-2" />
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Location</th>
                                            <td id="d_locker_id"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Landmark</th>
                                            <td id="d_location_landmark"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td id="d_location_address"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form method="POST" class="mt-2" action="{{ route('settings.location') }}">
                            @csrf
                            <div>
                                <input type="hidden" id="locker_id" name="locker_id">
                                <input type="hidden" id="location_address" name="location_address">
                                <input type="hidden" id="location_landmark" name="location_landmark">

                                <input type="hidden" id="h_client_name" name="h_client_name">
                                <input type="hidden" id="h_client_secret" name="h_client_secret">
                            </div>

                            <div class="text-center d-grid">
                                <button class="btn btn-lg win7-btn" id="btn_next" type="submit"> Next </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {

        $('#keyboard_location_id').jkeyboard({
            layout: "english",
            input: $('#location_id')
        });

        $('#keyboard_client_name').jkeyboard({
            layout: "english",
            input: $('#client_name')
        });

        $('#keyboard_client_secret').jkeyboard({
            layout: "english",
            input: $('#client_secret')
        });

        $('#keyboard_client_name').hide();
        $('#keyboard_client_secret').hide();

        $("#search").click(function(e) {
            e.preventDefault();
            var resource = '/get-locker-info';
            var apiEndpoint = "{{env('API_BASE_URL')}}" + "{{env('API_VERSION')}}" + resource;
            var locker_id = $("#location_id").val();
            var client_name = $("#client_name").val();
            var client_secret = $("#client_secret").val();

            $.ajax({
                    type: 'GET',
                    dataType: "json",
                    url: apiEndpoint,
                    headers: {
                        "appKey": "{{env('APP_KEY')}}",
                        // "clientSecret": "{{env('API_CLIENT_SECRET')}}",
                        // "client": "{{env('API_CLIENT')}}",
                        "clientSecret": client_secret,
                        "client": client_name,
                        "locationId": locker_id
                    },
                    data: {
                        "locker_id": locker_id
                    },
                })
                .done(function(data) {
                    $("#error_message").hide();
                    $(".server_error_message").hide();
                    $("#search_location").hide();
                    $("#display_location").show();
                    $("#btn_next").show();
                    $("#d_locker_id").text(data.data.locker_id);
                    $("#d_location_landmark").text(data.data.location_landmark);
                    $("#d_location_address").text(data.data.location_address);

                    $("#locker_id").val(data.data.locker_id);
                    $("#location_address").val(data.data.location_address);
                    $("#location_landmark").val(data.data.location_landmark);

                    $("#h_client_name").val(client_name);
                    $("#h_client_secret").val(client_secret);
                })
                .fail(function(data) {
                    $("#error_message").show();
                    $("#error_message").html(`<p>${data.responseJSON.reason}</p>`);
                    $("#btn_next").hide();

                    $("#d_locker_id").text('');
                    $("#d_location_landmark").text('');
                    $("#d_location_address").text('');

                    $("#locker_id").val('');
                    $("#location_address").val('');
                    $("#location_landmark").val('');

                    $("#h_client_name").val(client_name);
                    $("#h_client_secret").val(client_secret);
                });
        });
    });

    function myKeyboard(x) {
        if (x.id == 'location_id') {
            $('#keyboard_client_name').hide();
            $('#keyboard_client_secret').hide();
            $('#keyboard_location_id').show();
        } else if (x.id == 'client_name') {
            $('#keyboard_client_secret').hide();
            $('#keyboard_location_id').hide();
            $('#keyboard_client_name').show();
        } else {
            $('#keyboard_location_id').hide();
            $('#keyboard_client_name').hide();
            $('#keyboard_client_secret').show();
        }
    }
</script>
@endsection