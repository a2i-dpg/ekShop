<div wire:poll>

    <div class="box_booking_filters bg-light">
        <div class="location">

            @if (count($locker_ids) == count($user_all_locker_ids))
                All location
            @else
                @php
                    $lockers = App\Models\Locker::whereIn('locker_id', $locker_ids)->get();
                    // dd($locker_codes);
                @endphp
                @foreach ($lockers as $location)
                    <button type="button" class="btn btn-labeled btn-success" style="padding: 5px"
                        wire:click="unSetLocation('{{ $location->locker_id }}')">
                        <span class="btn-label">X</span>
                        {{ $location->locker_code }}
                    </button>
                @endforeach
            @endif

            @isset($locker_id)
                {{-- <button type="button" class="btn btn-labeled btn-success" wire:click="unSetLocation()">
                    <span class="btn-label">X</span>
                    {{ $locker_id }}
                </button> --}}
            @endisset

        </div>
        <div class="d-flex align-items-center gap-2 justify-content-center">
            <span>
                <span class="not_mobile-inline">Total Box: </span>
                <span class="number_badge not_mobile-inline box_number {{ $bgColorOfBadge }}">{{ $totalBox }}</span>
                <span id="totalBox" class="number_badge only_mobile box_number  {{ $bgColorOfBadge }}"
                    wire:click="showTotalBoxSizeDetails()">{{ $totalBox }}</span>
            </span>
            <span class="not_mobile-inline"> <span class="number_badge box_number {{ $bgColorOfBadge }}"
                    title="Small boxes: {{ $smallBox }}">{{ $smallBox }} S</span></span>
            <span class="not_mobile-inline"> <span class="number_badge box_number {{ $bgColorOfBadge }}"
                    title="Medium boxes: {{ $mediumBox }}"> {{ $mediumBox }} M</span></span>
            <span class="not_mobile-inline"> <span class="number_badge box_number {{ $bgColorOfBadge }}"
                    title="Large boxes: {{ $largeBox }}">{{ $largeBox }} L</span></span>
        </div>
        <div class="box_filter">
            <ul class="" style="display: flex !important;margin:0 !important">
                <li class="Legend-item" wire:click="setHideAndSHow">
                    <i class="{{ $filterIconClass }} booking_filter"></i>
                    <span class="Legend-label font-weight-bold">
                        @if ($newBooking)
                            New Booking
                        @elseif(sizeof($box_is_enable) == 1)
                            Available
                        @elseif(sizeof($box_is_booked) == 1)
                            Booked
                        @elseif(sizeof($box_is_in_maintenance) == 1)
                            Maintenance
                        @elseif(sizeof($box_is_closed) == 1)
                            Open
                        @elseif($is_max_pickup_time_passed)
                            Return
                        @elseif($show_disable_boxes)
                            Disabled
                        @else
                            No Filter Selected
                        @endif

                    </span>

                </li>

            </ul>
            <ul class="Legend {{ $hideAndShow }}">
                <li class="Legend-item {{ $this->newBooking ? 'selected_legend' : '' }}" wire:click="showNewBooking()">
                    <span class="Legend-colorBox new-booking">
                    </span>
                    <span class="Legend-label">
                        New Booking
                    </span>
                </li>
                <li class="Legend-item {{ sizeof($this->box_is_enable) > 1 ? '' : 'selected_legend' }}"
                    wire:click="showEnable()">
                    <span class="Legend-colorBox enable">
                    </span>
                    <span class="Legend-label">
                        Available
                    </span>
                </li>
                <li class="Legend-item {{ sizeof($this->box_is_booked) > 1 ? '' : 'selected_legend' }}"
                    wire:click="showBooked()">
                    <span class="Legend-colorBox booked">
                    </span>
                    <span class="Legend-label">
                        Booked
                    </span>
                </li>
                <li class="Legend-item {{ sizeof($this->box_is_in_maintenance) > 1 ? '' : 'selected_legend' }}"
                    wire:click="showMaintenence()">
                    <span class="Legend-colorBox mainenance">
                    </span>
                    <span class="Legend-label">
                        Maintanence
                    </span>
                </li>
                <li class="Legend-item {{ !$this->show_disable_boxes ? '' : 'selected_legend' }}"
                    wire:click="showDisabledBoxes()">
                    <span class="Legend-colorBox disable">
                    </span>
                    <span class="Legend-label">
                        Disabled
                    </span>
                </li>
                <li class="Legend-item {{ sizeof($this->box_is_closed) > 1 ? '' : 'selected_legend' }}"
                    wire:click="showOpen()">
                    <span class="Legend-colorBox box_open">
                    </span>
                    <span class="Legend-label">
                        Open
                    </span>
                </li>
                <li class="Legend-item {{ $is_max_pickup_time_passed ? 'selected_legend' : '' }}"
                    wire:click="showReturn()">
                    <span class="Legend-colorBox box_open">
                    </span>
                    <span class="Legend-label">
                        Return
                    </span>
                </li>
                <li class="Legend-item" wire:click="emptyFilter()">
                    <i class="fe-delete booking_filter"></i>
                    <span class="Legend-label">
                        Clear the filter
                    </span>
                </li>
            </ul>
        </div>

        <?php
        // print_r($locker_ids);
        ?>
        {{-- {{"Box ID: ".$boxId}} --}}
    </div>

    <div id="jq_total_boxes" class="total-boxes {{ $showTotalBoxSizeDetails ? 'd-block' : '' }} ">
        <ul>
            <li>Small Boxes: <span class="number_badge box_number {{ $bgColorOfBadge }}"
                    title="Small boxes: {{ $smallBox }}">{{ $smallBox }} </span></li>
            <li>Medium Boxes: <span class="number_badge box_number {{ $bgColorOfBadge }}"
                    title="Medium boxes: {{ $mediumBox }}"> {{ $mediumBox }} </span></li>
            <li>Large Boxes: <span class="number_badge box_number {{ $bgColorOfBadge }}"
                    title="Large boxes: {{ $largeBox }}">{{ $largeBox }} </span></li>
            <hr>
            <li>Total Boxes: <span class="number_badge box_number {{ $bgColorOfBadge }}">{{ $totalBox }}</span>
            </li>
        </ul>
    </div>

    <div class="row box-list row-cols-2 row-cols-xs-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-1">
        {{-- <button class="btn btn-md waves-effect waves-light box-btn" data-bs-toggle="modal" data-bs-target="#right-modal-1" >
            Open
        </button> --}}
        @if (!isset($boxes) || is_null($boxes) || count($boxes) <= 0)
            @if ($getALlBoxes)
                <p>Please Select Any Location</p>
            @else
                <p>No Data Found</p>
            @endif
        @else
            @foreach ($boxes as $box)
                <?php
                $header_bg = 'default';
                if ($box->box_is_booked) {
                    $header_bg = 'booked';
                } elseif (!$box->box_is_enable) {
                    $header_bg = 'disable';
                } elseif (!$box->box_is_booked && $box->box_is_enable && !$box->box_is_in_maintenance) {
                    $header_bg = 'enable';
                } elseif ($box->box_is_in_maintenance) {
                    $header_bg = 'mainenance';
                } elseif (!$box->box_is_closed) {
                    $header_bg = 'box_open';
                } else {
                    $header_bg = 'default';
                }
                
                // echo $header_bg;
                /*
                $header_bg = 'default';
                if ($box->box_is_booked) {
                    $header_bg = 'booked';
                } elseif ($box->box_is_enable) {
                    $header_bg = 'enable';
                } elseif (!$box->box_is_closed) {
                    $header_bg = 'box_open';
                } elseif ($box->box_is_in_maintenance) {
                    $header_bg = 'mainenance';
                } else {
                    $header_bg = 'default';
                }
                */
                // echo($box->bookings->isEmpty());
                // For New Booking
                if (!$box->bookings->isEmpty()) {
                    // echo $box->bookings[0]->customer_no;
                    if ($box->bookings[0]->customer_no == '' && $box->bookings[0]->booking_is_returned == 0) {
                        $header_bg = 'new-booking';
                    }
                }
                ?>
                <div class="col">
                    <div class="card booking_box" wire:click="setCustomerMobileNo({{ $box->id }})">
                        <div class="card-header {{ $header_bg }}">
                            <h6 class="">{{ $box->locker->locker_code }}</h6>
                            <h3 class="">{{ $box->box_no }}</h3>
                        </div>
                        <div class="card-body row">
                            {{-- {{$box->bookings}} --}}
                            <div class="{{ $box->box_is_booked && !$box->box_is_closed ? 'col-9' : 'col-12' }}">
                                <p class="card-text log_box_info ">
                                    <span class="box_open_close">
                                        @if ($box->box_is_closed)
                                            <strong class="close">Box Closed</strong>
                                        @else
                                            <strong class="open">Box Open</strong>
                                        @endif
                                    </span>
                                    {{-- <span>
                                    <strong>Box key: </strong> {{ $box->box_key }}
                                </span> --}}
                                    <span>
                                        <strong>Box No: </strong> {{ $box->box_no }}
                                    </span>
                                    <span>
                                        <strong>Box size:</strong> {{ $box->box_size }}
                                    </span>
                                </p>
                            </div>

                            @if ($box->box_is_booked && !$box->box_is_closed)
                                <div class="danger-box col-3">
                                    <i class="fe-alert-triangle" style="font-size:48px;color:red"></i>
                                    {{-- <i class="fe-shield" style="font-size:48px;color:red"></i> --}}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>


    {{-- Right Side Modal: box info --}}
    @livewire('dashboard.right-modal')


</div>
