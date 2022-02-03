@extends('admin.layouts.app')

@section('content')

<div class="plx-titlebar text-left mt-2 mb-3">
    <div class=" align-items-center">
        <h1 class="h3">{{translate('Wallet Transaction Report')}}</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('wallet-history.index') }}" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Wallet Transaction') }}</h5>
                    </div>
                    <div class="col d-flex">
                        @if(Auth::user()->user_type != 'seller')
                        <select id="demo-ease" class="form-control form-control-sm plx-selectpicker mb-2 mb-md-0" name="user_id">
                            <option value="">{{ translate('Choose User') }}</option>
                            @foreach ($users_with_wallet as $key => $user)
                                <option value="{{ $user->id }}" @if($user->id == $user_id) selected @endif >
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @endif
                        <div class="form-group mb-0 ml-3">
                            <input type="text" class="form-control form-control-sm plx-date-range" id="search" name="date_range"@isset($date_range) value="{{ $date_range }}" @endisset placeholder="{{ translate('Daterange') }}">
                        </div>
                        <button class="btn btn-sm btn-primary ml-3" type="submit">
                            {{ translate('Filter') }}
                        </button>
                    </div>
                </div>
            </form>
            <div class="card-body">

                <table class="table plx-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Customer')}}</th>
                            <th data-breakpoints="lg">{{  translate('Date') }}</th>
                            <th>{{ translate('Amount')}}</th>
                            <th data-breakpoints="lg">{{ translate('Payment Method')}}</th>
                            <th data-breakpoints="lg" class="text-right">{{ translate('Approval')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wallets as $key => $wallet)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                @if ($wallet->user != null)
                                    <td>{{ $wallet->user->name }}</td>
                                @else
                                    <td>{{ translate('User Not found') }}</td>
                                @endif
                                <td>{{ date('d-m-Y', strtotime($wallet->created_at)) }}</td>
                                <td>{{ single_price($wallet->amount) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $wallet ->payment_method)) }}</td>
                                <td class="text-right">
                                    @if ($wallet->offline_payment)
                                        @if ($wallet->approval)
                                            <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                                        @else
                                            <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="plx-pagination mt-4">
                    {{ $wallets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
