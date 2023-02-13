
<div>
    <h4 class=" text-center mb-3" style="margin:auto;font-weight: 700;font-size:16px;line-height:18px;color:rgb(0, 0, 0)">Delivery Man Booking Report</h4>
    <div class="card">
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
                        <th>Delivery man</th>
                        <th>Total Booking</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliveryManReport as $key => $data)
                        <tr class="style_counter_wrap">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ (isset($data->rider))? $data->rider->user_full_name : "N/A" }}
                            </td>
                            <td>
                                <span class="style_count text-white" style="width: auto;height:15px;border-radius:10px;padding:3px">{{ $data->total }}</span> 
                            </td>
                            <td>
                                <button wire:click.prevent = "findDeliveryMan('{{ $data->booked_by_user_id }}')" class=" btn btn-xs btn-purple companyEdit" data-bs-toggle="modal"
                                    data-bs-target="#deliveryManReport"><i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $deliveryManReport->links() }} --}}
        </div> <!-- end card body-->
    </div> <!-- end card -->
    {{-- Company edit Modal form --}}
    <!-- Modal -->

   
    <div wire:ignore.self class="modal fade" id="deliveryManReport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:800px">
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
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Customer Mobile</th>
                                <th>Parcel Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!is_null($deliveryBookingList))
                                @foreach ($deliveryBookingList as $key=>$item)
                                <tr class="style_counter_wrap">
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->rider->user_full_name }}</td>
                                    <td>{{ $item->rider->user_mobile_no }}</td>
                                    <td>{{ $item->rider->email }}</td>
                                    <td>
                                        {{ $item->customer_no }}   
                                    </td>
                                    <td>{{ $item->parcel_no }}</td>
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