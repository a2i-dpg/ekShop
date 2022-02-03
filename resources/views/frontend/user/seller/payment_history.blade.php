@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card">
        <div class="card-header border-bottom py-0">
            <div class="section-title border-bottom border-primary border-width-2 py-4 d-inline-block">{{ translate('Payment History') }}</div>
        </div>
        @if (count($payments) > 0)
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table plx-table mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Date')}}</th>
                            <th>{{ translate('Amount')}}</th>
                            <th class="text-nowrap">{{ translate('Payment Method')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($payments as $key => $payment)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                                <td>
                                    {{ single_price($payment->amount) }}
                                </td>
                                <td>
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} @if ($payment->txn_code != null) ({{  translate('TRX ID') }} : {{ $payment->txn_code }}) @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="plx-pagination">
                        {{ $payments->links() }}
                    </div>
                </div>

            </div>
        @endif
    </div>

@endsection
