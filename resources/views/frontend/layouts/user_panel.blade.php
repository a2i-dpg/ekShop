@extends('frontend.layouts.app')
@section('content')
<section class="pt-4 global-section-area-bottom">
    <div class="container">
        <div class="d-flex align-items-start user-panel-custom-sm">
			@include('frontend.inc.user_side_nav')
			<div class="plx-user-panel">
                <div class="dashboard-sold-amount-area global-section-area-bottom">
                    @if(Auth::user()->user_type == 'seller')
                        <div class="widget-balance">
                            <div class="widget-balance-left">
                                <h4 class="sold-amount text-center">{{ translate('Sold Amount')}}</h4>
                                @php
                                    $date = date("Y-m-d");
                                    $days_ago_30 = date('Y-m-d', strtotime('-30 days', strtotime($date)));
                                    $days_ago_60 = date('Y-m-d', strtotime('-60 days', strtotime($date)));
                                @endphp
                                <div class="heading-4 strong-700">
                                    @php
                                        $orderTotal = \App\Models\Order::where('seller_id', Auth::user()->id)->where("payment_status", 'paid')->where('created_at', '>=', $days_ago_30)->sum('grand_total');
                                        
                                    @endphp
                                    <small class="d-block sold-amount-detail mb-2">{{ translate('Your sold amount (current month)')}}</small>
                                    <span class="btn btn-primary sold-amount-count">{{ single_price($orderTotal) }}</span>
                                </div>
                            </div>
                            <div class="widget-balance-right table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        @php
                                            $orderTotal = \App\Models\Order::where('seller_id', Auth::user()->id)->where("payment_status", 'paid')->sum('grand_total');
                                        @endphp
                                        <td class="p-1" width="60%">
                                            {{ translate('Total Sold')}}:
                                        </td>
                                        <td class="p-1 fw-600" width="40%">
                                            {{ single_price($orderTotal) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        @php
                                            $orderTotal = \App\Models\Order::where('seller_id', Auth::user()->id)->where("payment_status", 'paid')->where('created_at', '>=', $days_ago_60)->where('created_at', '<=', $days_ago_30)->sum('grand_total');
                                        @endphp
                                        <td class="p-1" width="60%">
                                            {{ translate('Last Month Sold')}}:
                                        </td>
                                        <td class="p-1 fw-600" width="40%">
                                            {{ single_price($orderTotal) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
				@yield('panel_content')
            </div>
        </div>
    </div>
</section>
@endsection
