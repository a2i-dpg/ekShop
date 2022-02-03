@extends('admin.layouts.app')

@section('content')

<div class="plx-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3">{{translate('Products')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="card h-100">
			<div class="card-header">
				<h5 class="section-title mb-0">{{ translate('All Attributes')}}</h5>
			</div>
			<div class="card-body">
				<table class="table plx-table mb-0">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ translate('Name')}}</th>
							<th>{{ translate('Values')}}</th>
							<th class="text-right">{{ translate('Options')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($attributes as $key => $attribute)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$attribute->getTranslation('name')}}</td>
								<td>
									@foreach($attribute->attribute_values as $key => $value)
									<span class="badge badge-inline badge-md bg-soft-dark">{{ $value->value }}</span>
									@endforeach
								</td>
								<td class="text-right">
									<a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('attributes.show', $attribute->id)}}" title="{{ translate('Attribute values') }}">
										<i class="las la-cog"></i>
									</a>
									<a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('attributes.edit', ['id'=>$attribute->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
										<i class="las la-edit"></i>
									</a>
									<a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('attributes.destroy', $attribute->id)}}" title="{{ translate('Delete') }}">
										<i class="las la-trash"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="card h-100">
			<div class="card-header">
					<h5 class="section-title mb-0">{{ translate('Add New Attribute') }}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('attributes.store') }}" method="POST">
					@csrf
					<div class="form-group mb-3">
						<label for="name">{{translate('Name')}}</label>
						<input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" required>
					</div>
					<div class="form-group mb-3 text-right">
						<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
