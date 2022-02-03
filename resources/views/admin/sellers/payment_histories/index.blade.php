@extends('admin.layouts.app')

@section('content')
<div class="plx-titlebar text-left mt-2">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Sellers')}}</h1>
        </div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header">
        <h3 class="mb-0 h6">{{translate('Seller Payments')}}</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table plx-table mb-0">
                <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th data-breakpoints="lg">{{translate('Date')}}</th>
                    <th>{{translate('Seller')}}</th>
                    <th>{{translate('Amount')}}</th>
                    <th data-breakpoints="lg" class="text-right">{{ translate('Payment Details') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $key => $payment)
                    @if (\App\Models\Seller::find($payment->seller_id) != null && \App\Models\Seller::find($payment->seller_id)->user != null)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $payment->created_at }}</td>
                            <td>
                                @if (\App\Models\Seller::find($payment->seller_id) != null)
                                    {{ \App\Models\Seller::find($payment->seller_id)->user->name }} ({{ \App\Models\Seller::find($payment->seller_id)->user->shop->name }})
                                @endif
                            </td>
                            <td>
                                {{ single_price($payment->amount) }}
                            </td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} @if ($payment->txn_code != null) (TRX ID : {{ $payment->txn_code }}) @endif</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <div class="plx-pagination">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
