<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Agent</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Export Import</a></li>
                        <li class="breadcrumb-item active">Booking</li>
                    </ol>
                </div>
                <h4 class="page-title">Booking Lists</h4>
                @if (session()->has('delete'))
                    <div class="alert alert-danger">
                        {{ session('delete') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="filter" wire:ignore>
                <select name="" id="" class=" form-select location-highlight js-location-select2"
                    wire:model="selectedLocation">
                    <option value="{{ null }}">Select a Location</option>
                    @foreach ($lockers as $item)
                        <option value="{{ $item->locker_id }}" class="capitalize">
                            {{-- {{ str_replace('-', ' ', $item->locker_code) }} --}}
                            {{ $item->locker_code }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">

                    <div class="row mt-3">
                        <form action="{{ route('agent.bookingImportForCustomerNumber') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                <div class="custom-file text-left">
                                    <input type="file" accept=".csv" name="file" class="custom-file-input"
                                        id="customFile" onchange="checkfile(this);" required>
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <button class="btn btn-primary" class="import">
                                <i class="fe-upload"></i>
                                Import data
                            </button>
                            {{-- <a class="btn btn-success" href="{{ route('file-export') }}">Export data</a> --}}
                        </form>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4 d-flex align-items-center">
                            <button wire:click="bookingDataExport()" class="btn btn-sm btn-outline-purple"
                                style="margin-right:5px">
                                <i class="fe-save"></i>
                                Export
                            </button>
                            {{-- <button wire:click="bookingDataExport()" class=" btn btn-sm btn-outline-purple">
                                <i class="fe-save"></i>
                                Export All
                            </button> --}}
                        </div>
                        <div class="col-md-8 d-flex align-items-center justify-content-end capitalize"
                            style="font-size: 10px">
                            @if (count($allBooking) > 0)
                                <h5>
                                    {{ count($allBooking) }}
                                    @if (isset($bookingFilter))
                                        {{ $bookingFilter }} Bookings
                                    @endif

                                    @if (isset($selectedLocationCode))
                                        of
                                        <span class="location-highlight">
                                            {{ $selectedLocationCode }}
                                        </span>
                                    @endif

                                </h5>
                            @endif
                        </div>

                    </div>
                    <div class="row mt-3">

                        <div class="col-md-4 col-6">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="bookingFilter">
                                    <option value="new_booking" selected>New Booking</option>
                                    <option value="all">All</option>
                                    {{-- <option value="booked">Booked</option> --}}
                                    <option value="returned">Returned</option>
                                    {{-- <option value="last_day_for_collect">Last Day for Collcet</option> --}}
                                </select>
                            </div>
                        </div>

                        <div class="offset-md-4 col-md-4 col-6">
                            <input type="date" class=" form-control" wire:model="selectedDate">
                            {{-- {{$selectedDate}} --}}
                        </div>

                    </div>
                </div>

                <div class="row px-3 mt-2">
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
                            </select>
                        </div>
                    </div>
                    <div class="offset-md-4 col-md-6 col-8">
                        <div class="search">
                            <input type="text" wire:model.debounce.300ms='book_search_text'
                                placeholder="Type anything for search" class=" form-control">
                        </div>
                    </div>
                </div>
                <div id="booking_wrap" class="card-body table-responsive">
                    <table id="allBookingView" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>Booking ID</th> --}}
                                <th>Locker Info</th>
                                <th>Parcel No</th>
                                <th>Booked By</th>
                                <th>Booked Time</th>
                                <th>Time Status</th>
                                {{-- <th>View</th> --}}
                            </tr>
                        </thead>


                        <tbody>
                            @if (count($allBooking))
                                @foreach ($allBooking as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            <strong>Code: </strong> {{ $data->locker->locker_code }}<br>
                                            <strong>Location: </strong> {{ $data->locker->location_address }}<br>
                                            <strong>Box No: </strong> {{ $data->box->box_no }}
                                        </td>
                                        <td>
                                            <strong>Parcel No: </strong> {{ $data->parcel_no }}<br>
                                            <strong>Customer No: </strong> {{ $data->customer_no }}

                                        </td>
                                        <td>
                                            {{ isset($data->rider) ? $data->rider->user_full_name : 'N/A' }}
                                        </td>
                                        <td>{{ date('d-m-Y h:i', strtotime($data->booked_at)) }}</td>

                                        <td>
                                            @if ($data->is_max_pickup_time_passed == 0)
                                                <div class="spinner-grow text-success" role="status"
                                                    style="width: 10px;height:10px"></div>
                                            @else
                                                <div class="spinner-grow text-danger" role="status"
                                                    style="width: 10px;height:10px"></div>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <button wire:click="bookingView({{ $data->id }})"
                                                class=" btn btn-xs btn-success" data-bs-toggle="modal"
                                                data-bs-target="#bookingEdit"><i class=" fa fa-eye"></i></button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center">No Data Found</td>
                                </tr>
                                {{-- <tfoot><p>No Data Found</p></tfoot> --}}
                            @endif
                        </tbody>
                    </table>
                    {{ $allBooking->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    {{-- Booking view Modal form --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="bookingEdit" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Booking Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#home-b1" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link active">
                                    User Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                    Booking Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#messages-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                    Locker Information
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home-b1">
                                <div class="row">
                                    @if (!is_null($returnUserInfo))
                                        <div class="col-md-6 mb-3">
                                            <p class=" p-0 mb-0"><strong>Assinged delivery man for return:</strong>
                                            </p>
                                            <span>{{ $returnUserInfo->user_full_name }}</span><br>
                                            <span>{{ $returnUserInfo->user_mobile_no }}</span><br>
                                            <small>{{ $returnUserInfo->email }}</small>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""><strong>Customer Mobile Number:</strong></label>
                                            <input class=" form-control border-0 px-0" wire:model='customer_no'
                                                readonly>
                                        </div>
                                    </div>
                                    {{-- <hr class=" w-25"> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""><strong>Delivery Man:</strong></label>
                                            <input class=" form-control border-0 px-0" wire:model='booking_by_user_id'
                                                readonly>
                                            <input class=" form-control border-0 px-0" wire:model='deliveryManNumber'
                                                readonly>
                                            <input class=" form-control border-0 px-0" wire:model='deliveryManEmail'
                                                readonly>
                                            <input class=" form-control border-0 px-0" wire:model='deliveryManAddress'
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane show" id="profile-b1">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""><strong>Parcel Number:</strong></label>
                                        <input class=" form-control border-0 px-0" wire:model='parcel_no'
                                            value="check" readonly>
                                        <label for=""><strong>Booked at:</strong></label>
                                        <input class=" form-control border-0 px-0" wire:model='booked_at' readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="messages-b1">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""><strong>Locker Location:</strong></label>
                                        <input class=" form-control border-0 px-0" wire:model='locker_location'
                                            readonly>
                                        <label for=""><strong>Box Number:</strong></label>
                                        <input class=" form-control border-0 px-0" wire:model='box_no' readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" modal-footer">
                    @if (!is_null($collect_at) && is_null($collected_by))
                        <span class="badge bg-soft-warning text-warning">Picked</span>
                    @elseif(!is_null($collect_at) && !is_null($collected_by))
                        <span class="badge bg-soft-warning text-warning">Returned</span>
                    @else
                        <span class="badge bg-soft-warning text-warning">Processing..</span>
                    @endif

                    @if ($bookingStatus === 0 && is_null($assigned_person_to_return) && is_null($collected_by))
                        <div class="spinner-grow text-success" role="status" style="width: 20px;height:20px"></div>
                    @elseif($bookingStatus === 1 && is_null($assigned_person_to_return) && is_null($collected_by))
                        <button class="btn btn-danger btn-xs mx-5" type="button" data-bs-toggle="modal"
                            data-bs-target="#assingedUser" id="closedBookModal">
                            Assign Delivery Man
                        </button>
                    @elseif($bookingStatus === 1 && !is_null($assigned_person_to_return) && is_null($collected_by))
                        <span class="badge bg-soft-warning text-warning">Delivery man assigned</span>
                    @elseif($bookingStatus === 1 && !is_null($assigned_person_to_return) && !is_null($collected_by))
                        <span class="badge bg-soft-success text-success">Parcel Picked</span>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- Company Assigned User Modal form --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="assingedUser" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered;bg-dark"
            style="max-width:700px;box-shadow:4px 4px 8px rgba(0,0,0,0.2)">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Assign Delivery Man For Pickup</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('assigned'))
                        <div class="alert alert-success">{{ session('assigned') }}</div>
                    @endif
                    <form wire:submit.prevent="assignd_user({{ $current_id }})" method="POST">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="user_full_name" class="form-label">Delivery Man</label>
                                <select name="" id="" class=" form-control"
                                    wire:model='assign_delivery_man'>
                                    <option value="">Please Select</option>
                                    @foreach ($allDeliveryMan as $item)
                                        <option value="{{ $item->user_id }}">{{ $item->user_full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@section('custom_script')
    <script type="text/javascript" language="javascript">
        function checkfile(sender) {
            var validExts = new Array(".csv");
            var fileExt = sender.value;
            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
            if (validExts.indexOf(fileExt) < 0) {
                alert("Invalid file selected, valid files are of " +
                    validExts.toString() + " types.");
                return false;
                sender.value = null;
            } else return true;
        }
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
