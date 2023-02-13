<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Booking</a></li>
                        <li class="breadcrumb-item active">Booking SMS List</li>
                    </ol>
                </div>
                <h4 class="page-title">Booking SMS List</h4>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="filter" wire:ignore>
                <select name="" id="" class=" form-select location-highlight js-location-select2"
                    wire:model="selectedLocation">
                    <option value="{{ null }}">Select Location</option>
                    @foreach ($lockers as $item)
                        <option value="{{ $item->locker_id }}" class="capitalize">
                            <!-- {{ str_replace('-', ' ', $item->locker_id) }}  -->
                            {{ $item->locker_code }}
                        </option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="com-md-6">
            {{-- {{$selectedLocation}} --}}
        </div>
    </div>
    <style>
        .hover__action .action__btn a {
            cursor: pointer;
        }

        .hover__action .action__btn {
            opacity: 0;
            visibility: hidden;
        }

        .hover__action:hover .action__btn {
            opacity: 1 !important;
            visibility: visible !important;
        }

        .retry-date {
            border: 1px solid black;
            margin-right: 2px;
        }
    </style>



    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="search">
                                <input type="text" wire:model.debounce.300ms='search_text'
                                    placeholder="Type anything for search" class=" form-control">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="orderBy">
                                    <option value="id">ID</option>
                                    <option value="locker_id">Locker</option>
                                    <option value="is_sent">Message status</option>
                                    <option value="receiver_number">Customer Number</option>
                                    <th>#</th>
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
                        <div class=" col-md-2">
                            <a href="" wire:click.prevent="clearSearch" class=" btn btn-danger">Clear</a>
                        </div>
                    </div>

                </div>
                <div class="table-responsive card-body overflow-auto">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Locker Info</th>
                                <th>Customer Number</th>
                                <th>Parcel No</th>
                                @if ($showMessage)
                                    <th>SMS Text</th>
                                @endif
                                <th>Message status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bookingSms as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        {{ $data->locker->locker_code }}
                                    </td>
                                    <td>
                                        {{ $data->receiver_number }}
                                    </td>
                                    @php
                                        $msg_array = explode(' ', $data->sms_text);
                                        // $m_array = preg_grep('/^DEX\s.*/', $msg_array);
                                        $results = array_filter($msg_array, function ($value) {
                                            return strpos($value, 'DEX-') !== false;
                                        });
                                        // dd($msg_array, $results);
                                    @endphp
                                    <td>
                                        @if (count($results))
                                            {{ implode($results) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    @if ($showMessage)
                                        <td>
                                            <p style="max-width: 150px">
                                                {{ $data->sms_text }}
                                            </p>
                                        </td>
                                    @endif

                                    <td>
                                        @if ($data->is_sent == 0)
                                            <span class="badge bg-soft-warning text-warning">processing</span><br>
                                            <span>Date: {{ date('d-M-Y (h:i A)', strtotime($data->created_at)) }}</span>
                                        @else
                                            <span class="badge bg-soft-success text-success">sent</span>
                                            <br>
                                            <span>Date: {{ date('d-M-Y (h:i A)', strtotime($data->created_at)) }}</span>
                                        @endif

                                        @if ($data->resend_count)
                                            <hr>
                                            <span class="badge bg-soft-danger text-capitalize">Resend</span>
                                            <span>{{ $data->resend_count }} times</span>
                                            <br>
                                            <b>Dates:</b>
                                            @if (!is_null($data->resend_times))
                                                @php
                                                    $resend_times = json_decode($data->resend_times);
                                                @endphp
                                                @foreach ($resend_times as $date)
                                                    <span class="retry-date">
                                                        {!! date('d-M-Y (h:i A)', strtotime($date)) !!}
                                                    </span>
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($data->booking) && !is_null($data->booking->collected_at))
                                            @if (is_numeric($data->booking->collected_by))
                                                <b>Parcel Delivered</b>
                                                <br>
                                                <span class="collected-by">Collected By:
                                                    {{ $data->booking->collected_by }}</span>
                                            @else
                                                <b style="color: rgb(165, 69, 42)">Parcel Returned</b>
                                                <br>
                                                <span class="collected-by">
                                                    Returned By:
                                                    <a href="#">
                                                        {{-- {{$data->booking->collected_by}} --}}
                                                        {{ $data->booking->returnedByRider->user_full_name }}
                                                    </a>
                                                    <br>
                                                    ({{ $data->booking->returnedByRider->user_mobile_no }})
                                                </span>
                                            @endif
                                        @else
                                            @if ($data->resend_count < 3)
                                                <a wire:click.prevent="resend({{ $data->id }})"
                                                    class="text-small btn btn-success btn-sm">
                                                    resend
                                                </a>
                                            @else
                                                <b>Already resent 3 times</b>
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $bookingSms->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>

@section('custom_script')
    <script>
        $(document).ready(function() {
            $('.js-location-select2').on('change', function(e) {
                let selectedValue = $('.js-location-select2').select2("val");
                // console.log(selectedValue);
                @this.set('selectedLocation', selectedValue);
                // Livewire.emit('listenerReferenceHere', selectedValue);
            });
        });
    </script>
@endsection
