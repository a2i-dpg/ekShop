@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('content')

<div class="container-fluid">

    <div class="buttons">
        <a href="{{ route('dashboard') }}" class="win7-btn back-btn btn-lg" role="button"> Back </a>
        <a href="{{ route('logout') }}" class="win7-btn logout_btn btn-md" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
            <i class="dripicons-power logout_icon"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>


    <div class="content-conainer">
        <div class="right_side_box">
            <div class="row">
                <div class="col-xl-12 col-md-12">
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
                        <a href="{{ route('synchronize-company') }}" class="btn btn-secondary btn-lg btn-block waves-effect waves-light" role="button" aria-pressed="true">Company</a>

                        <a href="{{ route('synchronize-assets') }}" class="btn btn-info btn-lg btn-block waves-effect waves-light" role="button" aria-pressed="true">Assets</a>

                        <a href="{{ route('synchronize-users') }}" class="btn btn-secondary btn-lg btn-block waves-effect waves-light" role="button" aria-pressed="true">Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection