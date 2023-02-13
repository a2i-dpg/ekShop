<div>
    <h4 class=" text-center mb-3" style="margin:auto;font-weight: 700;font-size:16px;line-height:18px;color:rgb(0, 0, 0)">Company Total parcel</h4>
    <div class="card">
        <div class=" card-header bg-light">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="search">
                        <input type="text" wire:model.debounce.300ms='search_text'
                            placeholder="Type company name" class=" form-control">
                    </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-2 d-flex align-items-center">
                    <button wire:click="companyBookingExport()" class=" btn btn-sm btn-outline-purple">Export</button>
                </div>
            </div>
        </div>
        <style>
            .style_counter_wrap:nth-child(odd) .style_count{
                background: rgb(13, 170, 73);
            }
            .style_counter_wrap:nth-child(even) .style_count{
                background: rgb(228, 25, 59);
            }
        </style>
        <div class="card-body p-0">
            <div id="booking_count_wrap" class="table-responsive">
                <table id="company_parcel_count" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Total Parcel</th>
                            <th>Month</th> 
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookingData as $item)
                            <tr class="style_counter_wrap">
                                <td>{{ $item->company->company_name }}</td>
                                <td>
                                    <span class="style_count text-white" style="width: auto;height:15px;border-radius:10px;padding:3px">{{ $item->data }}</span>
                                </td>
                                <td>
                                    @php
                                        $monthNum  = $item->month;
                                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                        echo $monthName = $dateObj->format('F'); // March
                                    @endphp
                                </td>
                                <td>
                                    <button wire:click.prevent = 'findCompanyDetails("{{ $item->company_id }}")' class=" btn btn-xs btn-purple companyEdit" data-bs-toggle="modal"
                                        data-bs-target="#companyDetails"><i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
                {{ $bookingData->links() }}
            </div> <!-- end .table-responsive-->
        </div>
    </div> <!-- end card-->


    {{-- Company Details --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="companyDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Company Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="row table-responsive">
                            <table class=" table table-striped table-bordered">
                                <tbody>
                                    @if (!is_null($companyDetails))
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $companyDetails->company_email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td>{{ $companyDetails->company_contact_person_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $companyDetails->company_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Owner</th>
                                        <td>{{ $companyDetails->company_contact_person_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Joining Date</th>
                                        <td>{{ date("d-m-Y", strtotime($companyDetails->created_at)); }}</td>
                                    </tr>
                                    @else
                                        <tr>
                                            <td class=" text-center">No data found!!!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
