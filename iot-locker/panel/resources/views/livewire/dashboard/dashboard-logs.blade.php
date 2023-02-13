<div class="activity_tab">
    {{-- wire:poll --}}
    <div class="card">
        <i class="{{ $filterIconClass }} booking_filter" wire:click="setHideAndSHow"></i>
        <div class="card-header row bg-light filter_container">

            <div class="col-md-11 location_box">
                @if (count($selected_locations) == count($user_all_locations))
                    All location
                @else
                    @php
                        $lockers = App\Models\Locker::whereIn('locker_id', $selected_locations)->get();
                        // dd($locker_codes);
                    @endphp
                    @foreach ($lockers as $location)
                        <button type="button" class="btn btn-labeled btn-success"
                            wire:click="unSetLocation('{{ $location->locker_id }}')">
                            <span class="btn-label">X</span>
                            {{ $location->locker_code }}
                        </button>
                    @endforeach
                @endif
            </div>
            <div class="col-md-1">
                <div class="filter">
                    <select name="" id="" class="" wire:model="page_no">
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
            {{-- <div class="col-md-4">
                <div class="search">
                    <input type="text" wire:model.debounce.300ms='search_text' placeholder="Type company name" class=" form-control" id="">
                </div>
            </div> --}}

            <div class="col-md-1">
                <!-- <button wire:click="companyBookingExport()" class=" btn btn-sm btn-outline-purple">Export</button> -->
            </div>
        </div>

        <div class="card-header bg-light logs_filter_container_for_mobile">
            <div class="location_box">
                @if (count($selected_locations) == count($user_all_locations))
                    All location
                @else
                    @php
                        $lockers = App\Models\Locker::whereIn('locker_id', $selected_locations)->get();
                        // dd($locker_codes);
                    @endphp
                    @foreach ($lockers as $location)
                        <button type="button" class="btn btn-labeled btn-success"
                            wire:click="unSetLocation('{{ $location->locker_id }}')">
                            <span class="btn-label">X</span>
                            {{ $location->locker_code }}
                        </button>
                    @endforeach
                @endif
            </div>

            <div class="filter">
                <select name="" id="" class="" wire:model="page_no">
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

        <div class="card-body p-0">
            <div id="booking_count_wrap" class="table-responsive">
                <table id="dashboard-activity" class="table  table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                <input type="text" wire:model.debounce.300ms='what' placeholder="Filter by what"
                                    class="form-control" id="what">
                            </th>
                            <th>
                                <input type="text" wire:model.debounce.300ms='detail' placeholder="Filter by detail"
                                    class="form-control" id="detail">
                            </th>
                            <th>
                                <input type="text" wire:model.debounce.300ms='who' placeholder="Filter by who"
                                    class="form-control" id="who">
                            </th>
                            <th>
                                <input type="text" wire:model.debounce.300ms='when' name="daterange"
                                    class="form-control" />
                            </th>
                        </tr>
                        <tr>
                            <th>What</th>
                            <th>Detail</th>
                            <th>Who</th>
                            <th>When</th>
                        </tr>
                    </thead>
                    <tbody class="logs_body">
                        @foreach ($eventLogs as $item)
                            <?php
                            $loggedUser = null;
                            $danger = 0;
                            $tr_bg = 'default_row';
                            
                            $parcelId = null;
                            $bookingId = null;
                            $locationId = null;
                            $boxNo = null;
                            $boxStatus = null;
                            $customer_contact_no = null;
                            
                            // if (substr_count($item->log_event_description, 'logged') || substr_count($item->log_event_description, 'Parcel collected') || substr_count($item->log_event_description, 'box detected closed')) {
                            //     $tr_bg = 'default_row';
                            // }
                            
                            //get Logged User
                            $loggedUser = App\Models\Rider::where('user_id', $item->created_by)->first();
                            if (is_null($loggedUser)) {
                                $loggedUser = App\Models\User::where('user_id', $item->created_by)->first();
                            }
                            
                            $locationId = $item->locker->locker_code;
                            
                            if ($item->log_event_category == 'login') {
                                if ($item->log_event_subcategory == 'rider_login') {
                                    $tr_bg = 'default_row';
                                } elseif ($item->log_event_subcategory == 'admin_login') {
                                    $tr_bg = 'default_row';
                                } else {
                                    $tr_bg = 'default_row';
                                }
                            } elseif ($item->log_event_category == 'box') {
                                if ($item->log_event_subcategory == 'box_maintenance') {
                                    $tr_bg = 'maintenance_row';
                                } elseif ($item->log_event_subcategory == 'box_open') {
                                    $tr_bg = 'box_open_row';
                                    // $danger = 1;
                                } elseif ($item->log_event_subcategory == 'box_close') {
                                    $tr_bg = 'default_row';
                                }
                            
                                // Box Info
                                // for bug fixing
                                if(isset(json_decode($item->log_details)->box_info)){
                                    $boxInfo = json_decode($item->log_details)->box_info;
                                }else{
                                    $boxInfo = null;
                                }
                                
                                // dd($boxInfo);
                                if (isset($boxInfo)) {
                                    // $boxInfo = $bookingInfo->box;
                                    $boxNo = $boxInfo->box_no;
                                    $boxStatus = !$boxInfo->box_is_closed ? 'Open' : 'Close';
                                    if ($boxInfo->box_is_in_maintenance) {
                                        $boxStatus = 'Maintenance';
                                    }
                                    if ($boxInfo->box_is_booked) {
                                        $boxStatus = 'Booked';
                                    }
                                } else {
                                    $boxNo = 'N/A';
                                }
                            } elseif ($item->log_event_category == 'locker-master-activity') {
                                if ($item->log_event_subcategory == 'box_maintenance') {
                                    $tr_bg = 'maintenance_row';
                                } elseif ($item->log_event_subcategory == 'box_open') {
                                    $tr_bg = 'box_open_row';
                                    // $danger = 1;
                                } elseif ($item->log_event_subcategory == 'box_close') {
                                    $tr_bg = 'default_row';
                                }
                                // Box Info
                                $log_details = json_decode($item->log_details);
                                if (isset($log_details->box_info)) {
                                    if (isset($boxInfo)) {
                                        $boxInfo = $log_details->box_info;
                                        $boxNo = $boxInfo->box_no;
                                        $boxStatus = !$boxInfo->box_is_closed ? 'Open' : 'Close';
                                        if ($boxInfo->box_is_in_maintenance) {
                                            $boxStatus = 'Maintenance';
                                        }
                                        if ($boxInfo->box_is_booked) {
                                            $boxStatus = 'Booked';
                                        }
                                    } else {
                                        $boxNo = 'N/A';
                                    }
                                } else {
                                    $boxNo = 'N/A';
                                }
                            
                                // dd($boxInfo);
                            } elseif ($item->log_event_category == 'heartbeat') {
                                if ($item->log_event_subcategory == 'internet_online') {
                                    $tr_bg = 'connection_resume_row';
                                } else {
                                    $tr_bg = 'connection_lost_row';
                                }
                            } elseif ($item->log_event_category == 'booking') {
                                //log details
                                $logDetails = json_decode($item->log_details);
                                if (isset($logDetails->booking_info)) {
                                    $bookingInfo = $logDetails->booking_info;
                            
                                    $bookingId = $bookingInfo->booking_id;
                                    $parcelId = $bookingInfo->booking_parcel_no;
                            
                                    if ($item->log_event_subcategory == 'parcel_received') {
                                        $tr_bg = 'parcel_dropped_row';
                                        $customer_contact_no = $logDetails->contact_no;
                                    } elseif ($item->log_event_subcategory == 'booking_confirmed') {
                                        $tr_bg = 'parcel_dropped_row';
                                    }
                            
                                    // Box Info
                                    if (isset($bookingInfo->box)) {
                                        $boxInfo = $bookingInfo->box;
                                        $boxNo = $boxInfo->box_no;
                                        $boxStatus = !$boxInfo->box_is_closed ? 'Open' : 'Close';
                                        if ($boxInfo->box_is_in_maintenance) {
                                            $boxStatus = 'Maintenance';
                                        }
                                        if ($boxInfo->box_is_booked) {
                                            $boxStatus = 'Booked';
                                        }
                                    } else {
                                        $boxNo = 'N/A';
                                    }
                                } else {
                                    $boxNo = 'N/A';
                                }
                            
                                // dd($boxNo);
                                // $parcelId = null;
                                // $boxNo = $boxInfo->box_no;
                            } elseif ($item->log_event_category == 'parcel_in_danger' || $item->log_event_subcategory == 'parcel_in_danger') {
                                $danger = 1;
                                //log details
                                $logDetails = json_decode($item->log_details);
                                $bookingInfo = $logDetails->booking_info;
                            
                                $bookingId = $bookingInfo->booking_id;
                                $parcelId = $bookingInfo->booking_parcel_no;
                            
                                if ($item->log_event_subcategory == 'parcel_received') {
                                    $tr_bg = 'parcel_dropped_row';
                                    $customer_contact_no = $logDetails->contact_no;
                                } elseif ($item->log_event_subcategory == 'booking_confirmed') {
                                    $tr_bg = 'parcel_dropped_row';
                                }
                            
                                // Box Info
                                if (isset($bookingInfo->box)) {
                                    $boxInfo = $bookingInfo->box;
                                    $boxNo = $boxInfo->box_no;
                                    $boxStatus = !$boxInfo->box_is_closed ? 'Open' : 'Close';
                                    if ($boxInfo->box_is_in_maintenance) {
                                        $boxStatus = 'Maintenance';
                                    }
                                    if ($boxInfo->box_is_booked) {
                                        $boxStatus = 'Booked';
                                    }
                                } else {
                                    $boxNo = 'N/A';
                                }
                            }
                            
                            ?>
                            <tr class="style_counter_wrap {{ $tr_bg }}">
                                <td>
                                    <!-- class="capitalize" -->
                                    @if (!is_null($item->log_event_description))
                                        {!! str_replace('_', ' ', $item->log_event_description) !!}
                                    @else
                                        {!! str_replace('_', ' ', $item->log_event_category) !!}
                                    @endif

                                </td>
                                <td>
                                    <div class="log_box_info">
                                        @if (!is_null($parcelId))
                                            <span>
                                                <strong>PARCEL ID: </strong> <span
                                                    class="parcel_id">{{ $parcelId }}</span>
                                            </span>
                                        @endif
                                        @if (!is_null($bookingId))
                                            <span>
                                                <strong>BOOKING ID: </strong> {{ $bookingId }}
                                            </span>
                                        @endif
                                        @if (!is_null($locationId))
                                            <span>
                                                <strong>LOCATION ID: </strong> {{ $locationId }}
                                            </span>
                                        @endif

                                        @if (isset($bookingInfo->box))
                                            <span>
                                                @if (!is_null($boxNo) && $boxNo != 'N/A')
                                                    @php
                                                        $boxNumber = explode('-', $boxNo);
                                                        $boxNumber = $boxNumber[1];
                                                    @endphp
                                                    <strong>BOX: </strong> {{ $boxNumber }}
                                                @else
                                                    <strong>BOX: </strong> N/A
                                                @endif
                                            </span>
                                        @endif

                                        @if (!is_null($boxStatus))
                                            <span>
                                                <strong>BOX STATUS: </strong>
                                                <span class="box_status"> {{ $boxStatus }} </span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{-- {{$item->log_event_type}} --}}
                                    <!-- {{ str_replace('_', ' ', $item->log_event_type, $count) }} -->

                                    @if (!is_null($loggedUser))
                                        <strong>
                                            Rider:
                                        </strong>
                                        <span class="capitalize">{{ $loggedUser->user_full_name }}</span>
                                        <br>
                                        {{ $loggedUser->user_mobile_no }}
                                    @else
                                        {{ $item->created_by }}
                                        @if (!is_null($customer_contact_no))
                                            ({{ $customer_contact_no }})
                                        @endif
                                    @endif

                                    @if ($danger)
                                        <i class="fe-alert-triangle danger-icon" style="font-size:48px;color:red"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">

                                    <span>
                                        {{ $item->created_at->toFormattedDateString() }}
                                    </span>
                                    <br />
                                    <span>
                                        {{ $item->created_at->format('h:i A') }}
                                    </span>


                                    <!-- <strong>{{ $item->log_location_id }}</strong>
                                    <br>
                                    <div class="log_time">
                                        <span>
                                            <em>{{ $item->created_at->toFormattedDateString() }} </em>
                                        </span>
                                        <span>
                                            <strong>{{ $item->created_at->diffForHumans() }}</strong>
                                        </span>
                                    </div> -->

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $eventLogs->links() }}
            </div>
        </div>
    </div>

</div>
