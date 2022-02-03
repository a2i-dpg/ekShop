@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="card">
        <div class="card-header py-0">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="section-title border-bottom border-primary border-width-2 py-4">{{ translate('All Coupons') }}</div>
                <a href="{{ route('seller.coupon.create')}}" class="btn btn-primary btn-md h-100">{{ translate('Add New Coupon') }}</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table plx-table p-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th>{{translate('Code')}}</th>
                        <th data-breakpoints="lg">{{translate('Type')}}</th>
                        <th data-breakpoints="lg" class="text-nowrap">{{translate('Start Date')}}</th>
                        <th data-breakpoints="lg" class="text-nowrap">{{translate('End Date')}}</th>
                        <th width="10%" class="text-right">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $key => $coupon)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$coupon->code}}</td>
                            <td>@if ($coupon->type == 'cart_base')
                                    {{ translate('Cart Base') }}
                                @elseif ($coupon->type == 'product_base')
                                    {{ translate('Product Base') }}
                            @endif</td>
                            <td>{{ date('d-m-Y', $coupon->start_date) }}</td>
                            <td>{{ date('d-m-Y', $coupon->end_date) }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('seller.coupon.edit', encrypt($coupon->id) )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('seller.coupon.destroy', $coupon->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
