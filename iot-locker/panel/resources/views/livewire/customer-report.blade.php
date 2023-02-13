<div>
    <h4 class=" text-center mb-3" style="margin:auto;font-weight: 700;font-size:16px;line-height:18px;color:rgb(0, 0, 0)">Customer Data Report</h4>
    <div class="card">
        <div class="card-header bg-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="search">
                        <input type="text" wire:model.debounce.300ms='customer_number'
                            placeholder="Type customer mobile" class=" form-control">
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="filter">
                        <select name="" id="" class=" form-select" wire:model="filter_company">
                            <option value="">Select Company</option>
                            @foreach ($company as $item)
                                <option value="{{ $item->company_id }}">{{ $item->company->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
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
        <div id="company_wrap" class="card-body p-0 table-responsive">
            <table id="companyData_view" class="table table-bordered table-striped w-100 nowrap no-footer" role="grid" style="margin-left: 0px; width: 1112.16px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer Number</th>
                        <th>Total Booking</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerData as $key => $data)
                            <tr class="style_counter_wrap">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $data->customer_no }}</td>
                                <td>
                                    <span class="style_count text-white" style="width: auto;height:15px;border-radius:10px;padding:3px">{{ $data->total }}</span> 
                                </td>
                                <td>
                                    <button wire:click.prevent = 'findCustomer({{ $data->customer_no }})' class=" btn btn-xs btn-purple companyEdit" data-bs-toggle="modal"
                                        data-bs-target="#customerReport"><i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                    @endforeach  
                    
                </tbody>
            </table>
            {{ $customerData->links() }}
        </div> <!-- end card body-->
    </div> <!-- end card -->
    {{-- Company edit Modal form --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="customerReport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Booking Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table w-100 nowrap no-footer" role="grid" style="margin-left: 0px; width: 1112.16px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Company Mobile</th>
                                <th>Total Booking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!is_null($customerBookingList))
                                @foreach ($customerBookingList as $key=>$item)
                                <tr class="style_counter_wrap">
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->company->company_name }}</td>
                                    <td>{{ $item->company->company_contact_person_number }}</td>
                                    <td>
                                        <span class="style_count text-white" style="width: auto;height:15px;border-radius:10px;padding:3px">{{ $item->total }}</span>    
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
 @section('custom_script')
 
 @endsection