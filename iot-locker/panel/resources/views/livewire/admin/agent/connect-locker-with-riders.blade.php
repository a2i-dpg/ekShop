<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Connect</a></li>
                        <li class="breadcrumb-item active">Connect Riders With Locations</li>
                    </ol>
                </div>
                <h4 class="page-title">Assign Locations </h4>
                @if (session()->has('delete'))
                    <div class="alert alert-danger">
                        {!! session('delete') !!}
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {!! session('message') !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="offset-md-8 col-md-4 col-sm-12">
            <div class="input-group flex-nowrap" wire:ignore>
                <span class="input-group-text badge-soft-blue" id="addon-wrapping">Assign to</span>

                <select id="selectedLocation" class="form-select capitalize js-location-select2" wire:model="selectedLocation">
                    <option value="{{ null }}">Select a Location</option>
                    @foreach ($lockers as $item)
                        <option value="{{ $item->id }}" class="capitalize">
                            <!-- {{ str_replace('-', ' ', $item->locker_id) }}  -->
                            {{ $item->locker_code }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-2 col-sm-3 col-xs-3 col-4">
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

        <div class="offset-md-6 offset-sm-0 col-md-4 col-sm-9 col-xs-9 col-8">
            <div class="search">
                <input type="text" wire:model.debounce.300ms='rider_search_text'
                    placeholder="Type anything for search" class=" form-control">
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 table-responsive">
            <table id="deliveryManList" class="table nowrap">
                <thead>
                    <tr>
                        <th>
                            <a href="javascript:void(0)" id="checkAll" class="all-check">Check</a>
                            <br>
                            <a href="javascript:void(0)" id="uncheckAll" class="all-check">Uncheck</a>
                        </th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact Info</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riders as $key => $data)
                        <?php
                        $locationIds = $data->lockers->pluck('id');
                        $locationIds = json_decode(json_encode($locationIds), true);
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="" id="" class="rider_check"
                                    {{ in_array($selectedLocation, $locationIds) ? 'checked' : '' }}>
                                {{-- Rider ID --}}
                                <input type="hidden" name="" id="" class="rider_id"
                                    value="{{ $data->id }}" class="rider_check">
                            </td>
                            <td class="selectRow">{{ $key + 1 }}</td>
                            <td class="selectRow">{{ $data->user_full_name }}</td>
                            <td class="selectRow">
                                {{ $data->user_mobile_no }}
                                <br>
                                {{ $data->email }}
                            </td>
                            <td class="selectRow">{{ $data->user_address }}</td>

                            <th>Action</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $riders->links() }}
        </div>
    </div>

    @section('custom_script')
        <script>
            $(document).ready(function() {

                $(".selectRow").click(function(e) {
                    e.preventDefault();
                    if ($("#selectedLocation").val() == "") {
                        alert("Select a location");
                        $("#selectedLocation").addClass("required");
                        return false;
                    }
                    let checkbox = $(this).closest("tr").find("input:checkbox");
                    checkbox.click();
                });

                $(".rider_check").change(function(event) {
                    if ($("#selectedLocation").val() == "") {
                        alert("Select a location");
                        $("#selectedLocation").addClass("required");
                        event.preventDefault();
                        return false;
                    }
                    let riderID = $(this).closest('tr').find('.rider_id').val();

                    if (this.checked) {
                        console.log("checked" + riderID);
                        Livewire.emit('connectToLocation', riderID);
                    } else {
                        console.log("un checked" + riderID);
                        Livewire.emit('disconnectFromLocation', riderID);
                    }
                });
            });

            function checkAgentSelect() {
                if ($("#selectedLocation").val() == "") {
                    alert("Select a location");
                    $("#selectedLocation").addClass("required");
                    return false;
                }
            }
            $("#checkAll").click(function() {
                if ($("#selectedLocation").val() == "") {
                    alert("Select a location");
                    $("#selectedLocation").addClass("required");
                    return false;
                }
                $("input:checkbox:not(:checked)").click();
            });
            $("#uncheckAll").click(function() {
                if ($("#selectedLocation").val() == "") {
                    alert("Select a location");
                    $("#selectedLocation").addClass("required");
                    return false;
                }
                $("input:checkbox:checked").click();
            });

            window.addEventListener('toastr_show', event => {
                // console.log(event.detail.message);
                if (event.detail.message) {
                    toastr.success(event.detail.message, "Success", {
                        timeout: 3000
                    });
                }
                if (event.detail.error) {
                    toastr.error(event.detail.error, "Delete", {
                        timeout: 3000
                    });
                }
            });
        </script>


        <script>
            $(document).ready(function() {
                $('.js-location-select2').on('change', function(e) {
                    let selectedValue = $('.js-location-select2').select2("val");
                    @this.set('selectedLocation', selectedValue);
                });
            });
        </script>
    @endsection

</div>
