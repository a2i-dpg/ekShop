<div wire:poll.60s>
    {{-- wire:poll.30s --}}
    <div class="location_grid">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-1 row-cols-xl-1 justify-content-center gap-1">

            {{-- Location Search --}}
            <div class="form-group">
                <input type="text" class="form-control" wire:model="searchLocation" id="search-location"
                    aria-describedby="search-location-help" placeholder="Search">
                    {{-- {{$searchLocation}} --}}
                <small id="search-location-help" class="form-text text-muted">
                    Search By location Code or Address
                </small>
                <br>
                <a href="javascript:void(0)" wire:click="getALlBoxes">
                    <small>Get All Box Status</small>
                </a>
            </div>

            @if (!$locationData->isEmpty())
                @php
                    $i = 0;
                @endphp

                @foreach ($locationData as $key => $item)
                    <?php
                    $dt = \Carbon\Carbon::create($item->last_online_at);
                    $now = \Carbon\Carbon::create(\Carbon\Carbon::now()->toDateTimeString());
                    
                    $locker_class = 'normal';
                    // echo $dt->diffInMinutes($now);
                    if ($dt->diffInMinutes($now) > 8) {
                        $locker_class = 'warning';
                    
                        // $event_log = new App\Models\EventLog();
                        // $evet_log->log_location_id = $item->locker_code;
                        // $event_log->save();
                    } elseif ($dt->diffInMinutes($now) > 5) {
                        $locker_class = 'alert';
                    } elseif ($dt->diffInMinutes($now) > 1) {
                        $locker_class = 'offline';
                        App\Http\Livewire\Dashboard\LocationGrid::newActivity();
                    } else {
                        $locker_class = 'online';
                    }
                    ?>
                    {{-- <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom">
                        Tooltip on bottom
                    </button> --}}
                    <div class="singleBox {{ $locker_class }} col py-1 @if ($item->box_is_online == 0) box_maintain @endif"
                        wire:click="filterByLocation('{{ $item->locker_id }}')" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="{{$item->location_address}} ({{$item->location_landmark}})">

                        {{-- @if (count($selected_locker_ids))
                            {{$selected_locker_ids[0]}}
                        @endif --}}

                        @if (in_array($item->locker_id, $selected_locker_ids))
                            <i class="fa fa-check-circle icon"></i>
                        @endif
                        <div class="d-flex align-items-center justify-content-between flex-column">
                            <div class="box_name">
                                <h2 class="text-center m-0 title" style="font-size: 16px;font-weight:900">
                                    {{ $item->locker_code }}
                                </h2>
                                {{-- <p class="text-center" style="font-size:12px">{{ $item->locker->locker_id }}</p> --}}
                            </div>

                        </div>
                        <div>
                            @if ($item->last_online_at != null)
                                <div class="ofline_time">
                                    <p style="font-size: 10px">
                                        Last Online:
                                        {{ \Carbon\Carbon::parse($item->last_online_at)->diffForHumans(null, true) . ' ago' }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="box_status">
                            
                            {{-- <i class="fa fa-filter boxicon"
                                wire:click="filterByLocation('{{ $item->locker_id }}')"></i>
                            <i class="fa fa-eye boxicon"></i>
                            <i class="fa fa-edit boxicon"></i> --}}

                        </div>
                    </div>

                    @if ($item->box_is_online == 0)
                        @php
                            $i = $i + 1;
                        @endphp
                    @endif
                @endforeach
            @else
                <h3 class="no_data_found">No Location Allocated</h3>
            @endif
        </div>
    </div>
    {{-- <div class="d-flex justify-content-center dash_location_pagination">
        {!! $locationData->links() !!}
    </div> --}}


    <!-- Show Box Info Modal -->
    <div wire:ignore.self class="modal fade" id="showBox" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Box Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Box Key: </th>
                                    <td>
                                        <input type="text" wire:model='box_key' class=" border-0 form-control"
                                            readonly>
                                    </td>
                                    <th>Box Number: </th>
                                    <td>
                                        <input type="text" wire:model='box_no' class=" border-0 form-control"
                                            readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Locker ID: </th>
                                    <td>
                                        <input type="text" wire:model='locker_id' class=" border-0 form-control"
                                            readonly>
                                    </td>
                                    <th>Box Location: </th>
                                    <td>
                                        <input type="text" wire:model='box_location' class=" border-0 form-control"
                                            readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location Landmark: </th>
                                    <td>
                                        <input type="text" wire:model='location_landmark'
                                            class=" border-0 form-control" readonly>
                                    </td>
                                    <th>Box Size: </th>
                                    <td>
                                        <input type="text" wire:model='box_size'
                                            class=" border-0 form-control text-capitalize" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Box Online Status: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_online' class=" border-0 form-control"
                                            readonly>
                                    </td>
                                    <th>Box Enable: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_enable' class=" border-0 form-control"
                                            readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Box Maintenance: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_maintenance'
                                            class=" border-0 form-control" readonly>
                                    </td>
                                    <th>Box Booked: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_booked' class=" border-0 form-control"
                                            readonly>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
