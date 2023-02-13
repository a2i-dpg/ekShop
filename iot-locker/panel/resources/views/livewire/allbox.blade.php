<div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Box</a></li>
                        <li class="breadcrumb-item active">All Box</li>
                    </ol>
                </div>
                <h4 class="page-title">Box List</h4>
                @if (session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3" wire:ignore>
            <select name="" id="" class=" form-select location-highlight js-location-select2"
                wire:model="lockerLocation">
                <option value="">Filter by locker</option>
                @foreach ($allLocker as $data)
                    <option value="{{ $data->locker_id }}">
                        {{ $data->locker_code }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    {{-- <span class="location-highlight">
                        {{ $lockerLocation }}
                    </span> --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="search">
                                <input type="text" wire:model.debounce.300ms='box_search_text' placeholder="box-20"
                                    class=" form-control">
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="boxOrderBy">
                                    <option value="id">ID</option>
                                    <option value="box_no">Box No.</option>
                                    <option value="box_key">Box Key</option>
                                    <option value="box_size">Box Size</option>
                                    <option value="locker_id">Locker Location</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="asc_desc">
                                    <option value="1">Ascending</option>
                                    <option value="0">Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="page_no">
                                    <option value=10>10</option>
                                    <option value=15>15</option>
                                    <option value=20>20</option>
                                    <option value=25>25</option>
                                    <option value=30>30</option>
                                    <option value=50>50</option>
                                    <option value=100>100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row mt-3">
                        <div class="col-md-6 d-flex align-items-center gap-2">
                            <button wire:click="bookExport()" class=" btn btn-sm btn-outline-purple">Excel</button>
                            <button wire:click="bookExportPdf()" class=" btn btn-sm btn-outline-danger">PDF</button>
                            <button wire:click="bookExportCSV()" class=" btn btn-sm btn-outline-info">CSV</button>
                        </div>
                    </div> --}}
                </div>
                <div id="box_view_wrap" class="card-body table-responsive">
                    <table id="box_view" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Locker Location</th>
                                <th>Box Info</th>
                                <th>Box State</th>
                                <th>Status</th>
                                <th>Bookig Status</th>
                                <th>Emergency Box Open</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($box_info) <= 0)
                                <tr>
                                    <p>No data available</p>
                                </tr>
                            @else
                                @foreach ($box_info as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if (isset($data->locker))
                                                <strong>Locker:</strong>
                                                <span>{{ $data->locker->locker_code }}</span>
                                                <br>
                                                <strong>Address:</strong>
                                                <br>
                                                {{ $data->locker->location_address }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user_role == 'super-admin')
                                                <strong>Box key: </strong><span>{{ $data->box_key }}</span><br>
                                            @endif
                                            <strong>Box No: </strong><span
                                                class="bg-warning ">{{ $data->box_no }}</span><br>
                                            <strong>Box size: </strong><span>{{ $data->box_size }}</span>
                                        </td>
                                        <td>
                                            @if ($data->box_is_online === 1 && $data->box_is_enable === 1)
                                                <span class="badge bg-soft-success text-success">Online</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Offline</span>
                                            @endif
                                            @if ($data->box_is_online === 1 && $data->box_is_enable === 1 && $data->box_is_in_maintenance === 0)
                                                <span class="badge bg-soft-success text-success">Enable</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Disable</span>
                                            @endif
                                            @if ($data->box_is_closed === 1)
                                                <span class="badge bg-soft-success text-success">Closed</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Open</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->box_is_enable === 1 && $data->box_is_in_maintenance === 0)
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @elseif($data->box_is_enable === 0 && $data->box_is_in_maintenance === 1)
                                                <span class="badge bg-soft-danger text-danger">Maintainence</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($data->box_is_booked === 0)
                                                <span class="badge bg-soft-success text-success">Empty</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Booked</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->box_is_enable === 1 && $data->box_is_in_maintenance === 0)
                                                @if ($data->emergency_box_open)
                                                    <a href="javascript:void(0)" class="btn btn-warning"
                                                        wire:click='box_e_open("{{ $data->box_key }}")'>Close</a>
                                                @else
                                                    <a href="javascript:void(0)" class="btn btn-success"
                                                        wire:click='box_e_open("{{ $data->box_key }}")'>Open</a>
                                                @endif
                                            @else
                                                Can't open
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    {{ $box_info->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
            {{-- {{$box_info->links() }} --}}
        </div><!-- end col-->
    </div>
</div>
@section('custom_script')
    <script></script>
    <script>
        $(document).ready(function() {
            $('.js-location-select2').on('change', function(e) {
                let selectedValue = $('.js-location-select2').select2("val");
                @this.set('lockerLocation', selectedValue);
            });
        });
    </script>
@endsection
