@extends('admin.layouts.app')

@section('content')

<div class="plx-titlebar text-left mt-2">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('Staffs')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('staffs.create') }}" class="btn btn-create">
				<span>{{translate('Add New Staffs')}}</span>
			</a>
		</div>
	</div>
</div>
<br>
<div class="card">
    <div class="card-header">
        <h5 class="section-title mb-0">{{translate('All Staffs')}}</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table plx-table mb-0">
                <thead>
                <tr>
                    <th data-breakpoints="lg" width="10%">#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Email')}}</th>
                    <th data-breakpoints="lg">{{translate('Phone')}}</th>
                    <th data-breakpoints="lg">{{translate('Role')}}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($staffs as $key => $staff)
                    @if($staff->user != null)
                        <tr>
                            <td>{{ ($key+1) + ($staffs->currentPage() - 1)*$staffs->perPage() }}</td>
                            <td>{{$staff->user->name}}</td>
                            <td>{{$staff->user->email}}</td>
                            <td>{{$staff->user->phone}}</td>
                            <td>
                                @if ($staff->role != null)
                                    {{ $staff->role->getTranslation('name') }}
                                @endif
                            </td>
                            <td class="text-right">
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('staffs.edit', encrypt($staff->id))}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('staffs.destroy', $staff->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <div class="plx-pagination">
                {{ $staffs->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
