@extends('admin.layouts.app')

@section('content')
<div class="plx-titlebar text-left mt-2">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('Sales')}}</h1>
        </div>
    </div>
</div>
<br>

<div class="card">
    <form class="" action="" id="sort_orders" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="section-title mb-0">{{ translate('All Orders') }}</h5>
            </div>
            <div class="col-lg-2 ml-auto">
                <div class="dropdown mb-2 mb-md-0 float-right">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{translate('Bulk Action')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" onclick="bulk_delete()"> {{translate('Delete selection')}}</a>
                    </div>
                </div>
            </div>

            <!-- Change Status Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{translate('Choose an order status')}}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <select class="form-control plx-selectpicker" onchange="change_status()" data-minimum-results-for-search="Infinity" id="update_delivery_status">
                                <option value="pending">{{translate('Pending')}}</option>
                                <option value="confirmed">{{translate('Confirmed')}}</option>
                                <option value="picked_up">{{translate('Picked Up')}}</option>
                                <option value="on_the_way">{{translate('On The Way')}}</option>
                                <option value="delivered">{{translate('Delivered')}}</option>
                                <option value="cancelled">{{translate('Cancel')}}</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 ml-auto">
                <select class="form-control plx-selectpicker" name="delivery_status" id="delivery_status">
                    <option value="">{{translate('Filter by Delivery Status')}}</option>
                    <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option>
                    <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                    <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>{{translate('Picked Up')}}</option>
                    <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>{{translate('On The Way')}}</option>
                    <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{translate('Delivered')}}</option>
                    <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>{{translate('Cancel')}}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="plx-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table plx-table mb-0">
                    <thead>
                    <tr>
                        <th>
                            <div class="form-group">
                                <div class="plx-checkbox-inline">
                                    <label class="plx-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="plx-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </th>
                        <th>{{ translate('Order Code') }}</th>
                        <th data-breakpoints="md">{{ translate('Num. of Products') }}</th>
                        <th data-breakpoints="md">{{ translate('Customer') }}</th>
                        <th data-breakpoints="md">{{ translate('Amount') }}</th>
                        <th data-breakpoints="md">{{ translate('Delivery Status') }}</th>
                        <th data-breakpoints="md">{{ translate('Payment Status') }}</th>
                        @if (addon_is_activated('refund_request'))
                            <th>{{ translate('Refund') }}</th>
                        @endif
                        <th class="text-right" width="15%">{{translate('options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="plx-checkbox-inline">
                                        <label class="plx-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="{{$order->id}}">
                                            <span class="plx-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $order->code }}
                            </td>
                            <td>
                                {{ count($order->orderDetails) }}
                            </td>
                            <td>
                                @if ($order->user != null)
                                    {{ $order->user->name }}
                                @else
                                    Guest ({{ $order->guest_id }})
                                @endif
                            </td>
                            <td>
                                {{ single_price($order->grand_total) }}
                            </td>
                            <td>
                                @php
                                    $status = $order->delivery_status;
                                    if($order->delivery_status == 'cancelled') {
                                        $status = '<span class="badge badge-inline badge-danger">'.translate('Cancel').'</span>';
                                    }

                                @endphp
                                {!! $status !!}
                            </td>
                            <td>
                                @if ($order->payment_status == 'paid')
                                    <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                                @else
                                    <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                                @endif
                            </td>
                            @if (addon_is_activated('refund_request'))
                                <td>
                                    @if (count($order->refund_requests) > 0)
                                        {{ count($order->refund_requests) }} {{ translate('Refund') }}
                                    @else
                                        {{ translate('No Refund') }}
                                    @endif
                                </td>
                            @endif
                            <td class="text-right">
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                                    <i class="las la-eye"></i>
                                </a>
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                    <i class="las la-download"></i>
                                </a>
                                <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="plx-pagination">
                    {{ $orders->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        function bulk_delete() {
            var data = new FormData($('#sort_orders')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-order-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
