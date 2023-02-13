@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')
<style>
    /* .admin_dashboard {
        width: 40vw;
        height: 90vh;
        top: 10vh;
        position: fixed;
        right: 8vw;
        height: 100vh;
    } */
</style>

@section('content')

<div class="container-fluid">

    <a href="{{ route('logout') }}" class="win7-btn btn logout_btn btn-md btn-secondary btn-block waves-effect waves-light" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout <i class="dripicons-power logout_icon"></i>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>


    <div class="content-conainer">
        <div class="right_side_box">
            <div class="admin_dashboard">
                <div class="card">
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
                                                <td>{{ $location->location_id }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Landmark</th>
                                                <td>{{ $location->location_landmark }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address</th>
                                                <td>{{ $location->location_address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-list pe-xl-4 d-grid">
                    <a href="{{ route('synchronize-data') }}" class="btn btn-lg btn-info waves-effect waves-light" role="button" aria-pressed="true">Synchronize Data</a>
                    <a href="{{ route('locker-box.index') }}" class="btn btn-lg btn-secondary waves-effect waves-light" role="button" aria-pressed="true">Locker Box</a>
                    <!-- <a href="{{ route('video') }}" class="btn btn-lg btn-info waves-effect waves-light btn-block" role="button" aria-pressed="true">Video</a> -->
                    <a href="{{ route('maintenance') }}" class="btn btn-lg btn-secondary waves-effect waves-light btn-block" role="button" aria-pressed="true">Maintenance</a>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection