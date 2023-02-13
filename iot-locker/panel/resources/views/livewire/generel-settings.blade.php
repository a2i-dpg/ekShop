<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">All Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Assets lists</h4>
                @if (session('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-4">General Setting</h4>

                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#home-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                Logo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Slider
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#messages-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Admin Secret Key
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#messages-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Maximum Pickup Time
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#appkey" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                App Key
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane table-responsive active" id="home-b1">
                            <table id="allLogosettings" class="table w-100 nowrap dataTable no-footer" role="grid"
                                style="margin-left: 0px; width: 1112.16px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Setting Key</th>
                                        <th>Locker</th>
                                        <th>Setting content</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($logoSettings as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->settings_id }}</td>
                                            @if ($data->locker_id)
                                                <td>{{ $data->locker_id }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            <td>
                                                @php
                                                    $image = str_replace(['["','"]','images'],'',$data->setting_value);
                                                    $images = explode(',',$image);
                                                @endphp
                                                
                                               @foreach ($images as $item)
                                                   <img src="{{ asset('') }}storage/images{{ stripslashes($item) }}" alt="" class="img-fluid" style="width:80px">
                                               @endforeach
                                            </td>

                                            <td>
                                                <button wire:click="settingDelete({{ $data->id }})"
                                                    class=" btn btn-xs btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive show" id="profile-b1">
                            <table id="allSlidersettings" class="table w-100 nowrap dataTable no-footer" role="grid"
                                style="margin-left: 0px; width: 1112.16px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Setting Key</th>
                                        <th>Locker</th>
                                        <th>Setting content</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($sliderSettings as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->settings_id }}</td>
                                            @if ($data->locker_id)
                                                <td>{{ $data->locker_id }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            <td>
                                                @php
                                                    $image = str_replace(['[','"','"',']','images'],'',$data->setting_value);
                                                    $images = explode(',',$image);
                                                @endphp
                                                
                                               @foreach ($images as $item)
                                                   <img src="{{ asset('') }}storage/images{{ stripslashes($item) }}" alt="" class="img-fluid" style="width:60px">
                                               @endforeach
                                            </td>

                                            <td>
                                                <button wire:click="settingDelete({{ $data->id }})"
                                                    class=" btn btn-xs btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="messages-b1">
                            <table id="allAdminSecretsettings" class="table w-100 nowrap dataTable no-footer" role="grid"
                                style="margin-left: 0px; width: 1112.16px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Setting Key</th>
                                        <th>Locker</th>
                                        <th>Setting content</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($admin_secretSettings as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->settings_id }}</td>
                                            @if ($data->locker_id)
                                                <td>{{ $data->locker_id }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            <td>
                                                {{ $data->setting_value }}
                                            </td>

                                            <td>
                                                <button wire:click="settingDelete({{ $data->id }})"
                                                    class=" btn btn-xs btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="messages-b2">
                            <table id="allMaxPicksettings" class="table w-100 nowrap dataTable no-footer" role="grid"
                                style="margin-left: 0px; width: 1112.16px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Setting Key</th>
                                        <th>Locker</th>
                                        <th>Setting content</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($max_pickSettings as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->settings_id }}</td>
                                            @if ($data->locker_id)
                                                <td>{{ $data->locker_id }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            <td>
                                                {{ $data->setting_value }}
                                            </td>

                                            <td>
                                                <button wire:click="settingDelete({{ $data->id }})"
                                                    class=" btn btn-xs btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="appkey">
                            <table id="appKey" class="table w-100 nowrap dataTable no-footer" role="grid"
                                style="margin-left: 0px; width: 1112.16px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Setting Key</th>
                                        <th>Locker</th>
                                        <th>App Key</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($appKey as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->settings_id }}</td>
                                            @if ($data->locker_id)
                                                <td>{{ $data->locker_id }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            <td>
                                                {{ $data->setting_value }}
                                            </td>

                                            <td>
                                                
                                                <button wire:click="settingDelete({{ $data->id }})"
                                                    class=" btn btn-xs btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>
@section('custom_script')
    <script>
        $('#allLogosettings').DataTable({
            responsive:true,
            "bInfo": false,
        })

        $('#allSlidersettings').DataTable({
            responsive:true,
            "bInfo": false,
        })
        $('#allAdminSecretsettings').DataTable({
            responsive:true,
            "bInfo": false,
        })

        $('#allMaxPicksettings').DataTable({
            responsive:true,
            "bInfo": false,
        })
        $('#appKey').DataTable({
            responsive:true,
        "bInfo": false,
        })
    </script>
@endsection
