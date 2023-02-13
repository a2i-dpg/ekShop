<div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ol>
                </div>
                {{-- {{$dateForReport}} --}}
                <h4 class="page-title">Daily Report</h4>
            </div>
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <div class="filter" wire:ignore>
                        <select name="" id=""
                            class=" form-select location-highlight js-location-select2" wire:model="selectedLocation">
                            <option value="{{ null }}">Select Location</option>
                            @foreach ($lockers as $item)
                                <option value="{{ $item->locker_id }}" class="capitalize">
                                    <!-- {{ str_replace('-', ' ', $item->locker_id) }} -->
                                    {{ $item->locker_code }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class=" col-md-4 d-flex align-items-center gap-2 mobile-mt-1">
                    <input type="text" wire:model.debounce.300ms='dateRangeShow' name="daterange"
                        class="form-control" />
                </div>
            </div>
            <div class="dates">
                @for ($i = 0; $i < 7; $i++)
                    @if ($i == 0)
                        <button wire:click="setDateForReport({{ $i }})"
                            class=" btn btn-sm btn-outline-purple {{ $active == $i ? 'active' : '' }}">
                            Today
                        </button>
                    @elseif ($i == 1)
                        <button wire:click="setDateForReport({{ $i }})"
                            class=" btn btn-sm btn-outline-purple {{ $active == $i ? 'active' : '' }}">
                            Yesterday
                        </button>
                    @else
                        <button wire:click="setDateForReport({{ $i }})"
                            class=" btn btn-sm btn-outline-purple {{ $active == $i ? 'active' : '' }}">
                            {{ Carbon\Carbon::now()->subDays($i)->format('D') }}
                            ( {{ Carbon\Carbon::now()->subDays($i)->format('Y-m-d') }} )
                        </button>
                    @endif
                @endfor

            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row ">
                        <div class="col-md-6 col-12 booked_numbers gap-2">
                            <p>Booked: <span class="number_badge booked_number">{{ $total_booked_by_date }}</span></p>
                            <p>
                                Collected: <span class="number_badge collected_number">{{ $collected_by_date }}
                                </span>
                                Returned: <span class="number_badge booked_number">{{ $returned_by_date }} </span>
                            </p>
                            <p>
                                Not Collected: 
                                <span class="number_badge not_collected_number">{{ $not_collected_by_date }}</span>
                            </p>
                            <p>
                                Pre-booked: 
                                <span class="number_badge not_collected_number">
                                    {{-- {{ ($todayTotalPending - $total_booked_by_date) }} --}}
                                    {{$preBooked}}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 col-12 d-flex align-items-center gap-2 justify-content-end">

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <p class="" style="border: 1px solid gray">
                                        <span>By Date:</span>
                                        <span class="number_badge">Collected:
                                            {{ $todayTotalCollected }}</span>
                                        <span class="number_badge" wire:click="todayReturn()" style="cursor: pointer">
                                            Return:
                                            {{ $todayTotalReturn }}
                                        </span>
                                    </p>

                                </div>
                                <div class="col-md-6 col-12">
                                    <p>
                                        <span class="number_badge">Total Pending:
                                            {{ $todayTotalPending }}</span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-4 d-flex align-items-center gap-2">
                            <button wire:click="Export()" class=" btn btn-sm btn-outline-purple">
                                Excel <i class="fe-save"></i>
                            </button>
                            {{-- <button wire:click="ExportPdf()" class=" btn btn-sm btn-outline-danger">PDF</button> --}}
                            <button wire:click="ExportCSV()" class=" btn btn-sm btn-outline-info">
                                CSV <i class="fe-save"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2 col-4">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="page_no">
                                    <option value=10>10</option>
                                    <option value=15>15</option>
                                    <option value=20>20</option>
                                    <option value=25>25</option>
                                    <option value=30>30</option>
                                    <option value=50>50</option>
                                    <option value=100>100</option>
                                    <option value=500>500</option>
                                    <option value=1000>1000</option>
                                    <option value=3000>3000</option>
                                    <!-- <option value=5000>5000</option> -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-8">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="selectedStatus">
                                    <option value="{{ null }}">Select Status</option>
                                    <option value="not_collected">Not Collected</option>
                                    <option value="collected">Collected</option>
                                    <option value="returned">Returned</option>
                                    <option value="returned_by_agent">Returned By Agent</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mobile-mt-1">
                            <div class="search">
                                <input type="text" wire:model.debounce.300ms='company_report_search_text'
                                    placeholder="Type anything for search" class=" form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mobile-mt-1">
                            <div class="search">
                                <input type="text" wire:model.debounce.300ms='company_report_search_text2'
                                    placeholder="Type anything for search" class=" form-control">
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <a href="" wire:click.prevent="clearSearch" class=" btn btn-danger">Clear</a>
                        </div> --}}
                    </div>

                </div>
                <div id="company_wrap" class="card-body">
                    <div class="table-responsive">
                        <table id="companyData_view" class="table w-100 nowrap no-footer" role="grid"
                            style="margin-left: 0px; width: 1112.16px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Location</th>
                                    <th>Box No</th>
                                    <th>Parcel No</th>
                                    <th>Customer Info</th>
                                    <th>Booked By</th>
                                    <th>Collected BY</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $key => $data)
                                    <?php
                                    $bookingStatus = '';
                                    $collectedByRider = false;
                                    if (!is_null($data->booked_at)) {
                                        $bookingStatus = 'Booked';
                                    }
                                    if (!is_null($data->customer_sms_key)) {
                                        $bookingStatus = $bookingStatus . '& SMS Sent';
                                    }
                                    if (!is_null($data->collected_at)) {
                                        $bookingStatus = 'Collected';
                                    }
                                    if ($data->booking_is_returned) {
                                        $bookingStatus = 'Returned';
                                        $collectedByRider = true;
                                    }
                                    if ($data->is_max_pickup_time_passed == 0 && $data->booking_is_returned) {
                                        $bookingStatus = 'Returned By Agent'.' before time pass';
                                        $collectedByRider = true;
                                    }
                                    if ($data->is_max_pickup_time_passed == 1 && $data->booking_is_returned=0) {
                                        // $bookingStatus = 'Collected By Customer'.' *After time pass';
                                        $bookingStatus = 'Collected';
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $data->locker->locker_code }}
                                            <br>
                                            {{ $data->locker->location_address }}
                                            <br>
                                            {{ $data->locker->location_landmark }}
                                        </td>
                                        <td>
                                            {{ $data->box->box_no }}
                                        </td>
                                        <td>
                                            {{ $data->parcel_no }}
                                        </td>
                                        <td>
                                            <input class="customer_no_input" type="text"
                                                value="{{ $data->customer_no }}" hidden>
                                            {{ $data->customer_no }}
                                            <br>
                                            <strong>Company-OTP: {{ $data->booking_company_otp }} </strong>
                                        </td>
                                        <td>
                                            <input class="rider_no_input" type="text"
                                                value="{{ $data->rider->user_mobile_no }}" hidden>
                                            <span class=" pointer"
                                                title="{{ $data->rider->user_mobile_no }}">{{ $data->rider->user_full_name }}
                                            </span>

                                            <br>
                                            {{ $data->rider->user_mobile_no }}
                                            <br>
                                            {{ $data->booked_at }}
                                        </td>
                                        <td>
                                            {{-- @if ($data->is_max_pickup_time_passed || $data->booking_is_returned) --}}
                                            @if ($collectedByRider)
                                                @php
                                                    $rider = App\Models\Rider::where('user_id', $data->collected_by)->first();
                                                    
                                                @endphp
                                                @if (isset($rider))
                                                    <strong>
                                                        Rider:
                                                    </strong>
                                                    <span class=" pointer">
                                                        {{ $rider->user_full_name }}
                                                    </span>
                                                @else
                                                    <span class=" pointer">{{ $data->collected_by }}</span>
                                                @endif
                                            @else
                                                <span class=" pointer">{{ $data->collected_by }}</span>
                                            @endif

                                            <br>
                                            {{ $data->collected_at }}
                                        </td>
                                        <td>
                                            {{ $bookingStatus }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $bookings->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>
@section('custom_script')
    <script>
        $(document).ready(function() {
            // console.log("fadeout filter");
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                Livewire.emit('setDateRange', start.format('YYYY-MM-DD'), end.format(
                    'YYYY-MM-DD 23:59:59'));
            });
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
