@extends('admin.layouts.app')

@section('content')
<div class="plx-titlebar text-left mt-2">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Seller Based Selling Report')}}</h1>
	</div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('seller_sale_report.index') }}" method="GET">
                    <div class="form-group">
                        <label class="col-form-label fs-18">{{translate('Sort by verificarion status')}} :</label>
                            <select class="from-control plx-selectpicker ml-3" name="verification_status" required>
                               <option value="1" @if($sort_by == '1') selected @endif>{{ translate('Approved') }}</option>
                               <option value="0" @if($sort_by == '0') selected @endif>{{ translate('Non Approved') }}</option>
                            </select>
                            <button class="btn btn-primary ml-3" type="submit">{{ translate('Filter') }}</button>
                    </div>
                </form>

                <table class="table table-bordered plx-table mb-0">
                    <thead>
                        <tr>
                            <th>{{ translate('Seller Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Shop Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Number of Product Sale') }}</th>
                            <th>{{ translate('Order Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellers as $key => $seller)
                            @if($seller->user != null)
                                <tr>
                                    <td>{{ $seller->user->name }}</td>
                                    @if($seller->user->shop != null)
                                        <td>{{ $seller->user->shop->name }}</td>
                                    @else
                                        <td>--</td>
                                    @endif
                                    <td>
                                        @php
                                            $num_of_sale = 0;
                                            foreach ($seller->user->products as $key => $product) {
                                                $num_of_sale += $product->num_of_sale;
                                            }
                                        @endphp
                                        {{ $num_of_sale }}
                                    </td>
                                    <td>
                                        {{ single_price(\App\Models\OrderDetail::where('seller_id', $seller->user->id)->sum('price')) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="plx-pagination mt-4">
                    {{ $sellers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
