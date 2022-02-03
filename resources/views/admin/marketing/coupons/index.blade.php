@extends('admin.layouts.app')

@section('content')
<div class="plx-titlebar text-left mt-2">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('Marketing')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('coupon.create') }}" class="btn btn-create">
				<span>{{translate('Add New Coupon')}}</span>
			</a>
		</div>
	</div>
</div>
<br>
<div class="card">
  <div class="card-header">
      <h5 class="mb-0 section-title">{{translate('Coupon Information')}}</h5>
  </div>
  <div class="card-body">
      <div class="table-responsive">
          <table class="table plx-table p-0">
              <thead>
              <tr>
                  <th data-breakpoints="lg">#</th>
                  <th>{{translate('Code')}}</th>
                  <th data-breakpoints="lg" class="text-nowrap">{{translate('Type')}}</th>
                  <th data-breakpoints="lg" class="text-nowrap">{{translate('Start Date')}}</th>
                  <th data-breakpoints="lg" class="text-nowrap">{{translate('End Date')}}</th>
                  <th width="10%" class="text-right">{{translate('Options')}}</th>
              </tr>
              </thead>
              <tbody>
              @foreach($coupons as $key => $coupon)
                  <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$coupon->code}}</td>
                      <td>@if ($coupon->type == 'cart_base')
                              {{ translate('Cart Base') }}
                          @elseif ($coupon->type == 'product_base')
                              {{ translate('Product Base') }}
                          @endif</td>
                      <td>{{ date('d-m-Y', $coupon->start_date) }}</td>
                      <td>{{ date('d-m-Y', $coupon->end_date) }}</td>
                      <td class="text-right">
                          <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('coupon.edit', encrypt($coupon->id) )}}" title="{{ translate('Edit') }}">
                              <i class="las la-edit"></i>
                          </a>
                          <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('coupon.destroy', $coupon->id)}}" title="{{ translate('Delete') }}">
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

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
