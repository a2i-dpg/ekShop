@extends('admin.layouts.app')

@section('content')
<div class="plx-titlebar text-left mt-2">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Product wise stock report')}}</h1>
	</div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!--card body-->
            <div class="card-body">
                <form action="{{ route('stock_report.index') }}" method="GET">
                    <div class="form-group">
                        <label class="col-form-label fs-18">{{translate('Sort by Category')}} :</label>
                            <select id="demo-ease" class="from-control plx-selectpicker ml-3" name="category_id" required>
                                @foreach (\App\Models\Category::all() as $key => $category)
                                    <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary ml-3" type="submit">{{ translate('Filter') }}</button>
                    </div>
                </form>
                <table class="table table-bordered plx-table mb-0">
                    <thead>
                        <tr>
                            <th>{{ translate('Product Name') }}</th>
                            <th>{{ translate('Stock') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            @php
                                $qty = 0;
                                foreach ($product->stocks as $key => $stock) {
                                    $qty += $stock->qty;
                                }
                            @endphp
                            <tr>
                                <td>{{ $product->getTranslation('name') }}</td>
                                <td>{{ $qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="plx-pagination mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
