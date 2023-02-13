<div>
    <div class="box_grid">
        <div class="row justify-content-center gap-2">
            @php
                $i = 0;
            @endphp
            @foreach ($boxData as $key => $item)
                <div wire:click.prevent='showBox({{ $item->id }})'
                    class="singleBox py-1 col-md-2 shadow-lg bg-white rounded-3 d-flex align-items-center justify-content-center flex-column @if ($item->box_is_online == 0) box_maintain @endif"
                    style="cursor:pointer;min-height:50px;@if ($item->box_is_online == 0 || $item->box_is_in_maintenance) order:{{ $i }} @else order:100 @endif"
                    data-bs-toggle="modal" data-bs-target="#showBox">
                    <div class="d-flex align-items-center justify-content-between flex-column">
                        <div class="box_name">
                            <h2 class="text-center m-0" style="font-size: 16px;font-weight:900">{{ $item->box_no }}
                            </h2>
                            <p class="text-center" style="font-size:12px">{{ $item->locker->locker_id }}</p>
                        </div>
                        <div class="box_status d-flex align-items-center justify-content-between">
                            @if ($item->box_is_online && $item->box_is_enable)
                                <div class="spinner-grow text-success m-2" role="status" style="width: 10px;height:10px">
                                </div>
                            @else
                                <div class="spinner-grow text-danger m-2" role="status" style="width: 10px;height:10px">
                                </div>
                            @endif

                            @if ($item->box_is_enable)
                                <div><i class="fa fa-check text-success"></i></div>
                            @else
                                <div><i class="fa fa-plug text-danger"></i></div>
                            @endif

                            @if ($item->box_is_in_maintenance)
                                <div><i class="fas fa-gavel text-danger"></i></div>
                            @else
                                <div></div>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if ($item->going_offline_time != null)
                            <div class="ofline_time">
                                <p style="font-size: 10px">Last Online:
                                    {{ \Carbon\Carbon::parse($item->going_offline_time)->diffForHumans(null, true) . ' ago' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($item->box_is_online == 0)
                    @php
                        $i = $i + 1;
                    @endphp
                @endif
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {!! $boxData->links() !!}
    </div>


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
                                        <input type="text" wire:model='box_key' class=" border-0 form-control" readonly>   
                                    </td>
                                    <th>Box Number: </th>
                                    <td>
                                        <input type="text" wire:model='box_no' class=" border-0 form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Locker ID: </th>
                                    <td>
                                        <input type="text" wire:model='locker_id' class=" border-0 form-control" readonly>
                                    </td>
                                    <th>Box Location: </th>
                                    <td>
                                        <input type="text" wire:model='box_location' class=" border-0 form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location Landmark: </th>
                                    <td>
                                        <input type="text" wire:model='location_landmark' class=" border-0 form-control" readonly>
                                    </td>
                                    <th>Box Size: </th>
                                    <td>
                                        <input type="text" wire:model='box_size' class=" border-0 form-control text-capitalize" readonly>
                                    </td>
                                </tr>
                               <tr>
                                    <th>Box Online Status: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_online' class=" border-0 form-control" readonly>
                                    </td>
                                    <th>Box Enable: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_enable' class=" border-0 form-control" readonly>
                                    </td>
                               </tr>
                               <tr>
                                    <th>Box Maintenance: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_maintenance' class=" border-0 form-control" readonly>
                                    </td>
                                    <th>Box Booked: </th>
                                    <td>
                                        <input type="text" wire:model='box_is_booked' class=" border-0 form-control" readonly>
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
