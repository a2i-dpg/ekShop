<form action="{{ route('commission-log.index') }}" method="GET">
    <div class="card-header row gutters-5 py-0">
        <div class="col-md-6 col-sm-12 text-md-left">
            <div class="section-title border-bottom border-primary border-width-2 mb-0 py-4 d-inline-block w-auto">{{ translate('Commission History') }}</div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="d-flex justify-content-end align-items-center">
                @if(Auth::user()->user_type != 'seller')
                    <select id="demo-ease" class="form-control form-control-sm plx-selectpicker mb-2 mb-md-0" name="seller_id">
                        <option value="">{{ translate('Choose Seller') }}</option>
                        @foreach (\App\Models\Seller::all() as $key => $seller)
                            @if(isset($seller->user->id))
                                <option value="{{ $seller->user->id }}" @if($seller->user->id == $seller_id) selected @endif >
                                    {{ $seller->user->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                @endif
                <div class="form-group mb-0w-100 d-flex justify-content-end justify-content-sm-start justify-content-xs-start w-100 my-1 ml-3">
                    <input type="text" class="form-control form-control-sm plx-date-range" id="search" name="date_range"@isset($date_range) value="{{ $date_range }}" @endisset placeholder="{{ translate('Daterange') }}">
                </div>
                <div class="form-group mb-0w-100 d-flex justify-content-end justify-content-sm-start justify-content-xs-start my-1 ml-3">
                    <button class="btn btn-sm btn-primary" type="submit">
                        {{ translate('Filter') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="card-body">
    <div class="table-responsive">
        <table class="table plx-table mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th data-breakpoints="lg" class="text-nowrap">{{ translate('Order Code') }}</th>
                <th class="text-nowrap">{{ translate('Admin Commission') }}</th>
                <th class="text-nowrap">{{ translate('Seller Earning') }}</th>
                <th data-breakpoints="lg" class="text-nowrap text-right">{{ translate('Created At') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($commission_history as $key => $history)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>
                        @if(isset($history->order))
                            {{ $history->order->code }}
                        @else
                            <span class="badge badge-inline badge-danger">
                            translate('Order Deleted')
                        </span>
                        @endif
                    </td>
                    <td>{{ $history->admin_commission }}</td>
                    <td>{{ $history->seller_earning }}</td>
                    <td class="text-right">{{ $history->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="plx-pagination mt-4">
            {{ $commission_history->links() }}
        </div>
    </div>
</div>
