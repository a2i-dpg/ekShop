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
<div class="row">

    <div class="col-md-12">
        <div class="card">
    		<div class="card-header">
    			<h1 class="section-title mb-0">{{translate('User Search Report')}}</h1>
    		</div>
            <div class="card-body">
                <table class="table table-bordered plx-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Search By') }}</th>
                            <th>{{ translate('Number searches') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($searches as $key => $searche)
                            <tr>
                                <td>{{ ($key+1) + ($searches->currentPage() - 1)*$searches->perPage() }}</td>
                                <td>{{ $searche->query }}</td>
                                <td>{{ $searche->count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="plx-pagination mt-4">
                    {{ $searches->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
