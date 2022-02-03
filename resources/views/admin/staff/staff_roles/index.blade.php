@extends('admin.layouts.app')

@section('content')

<div class="plx-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('Staffs')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('roles.create') }}" class="btn btn-create">
				<span>{{translate('Add New Role')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="section-title mb-0">{{translate('All Roles')}}</h5>
    </div>
    <div class="card-body">
        <table class="table plx-table">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{translate('Name')}}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $key => $role)
                    <tr>
                        <td>{{ ($key+1) + ($roles->currentPage() - 1)*$roles->perPage() }}</td>
                        <td>{{ $role->getTranslation('name')}}</td>
                        <td class="text-right">
                            <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('roles.edit', ['id'=>$role->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('roles.destroy', $role->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="plx-pagination">
            {{ $roles->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
