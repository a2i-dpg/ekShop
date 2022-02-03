@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card mb-0">
        <div class="card-header border-bottom py-0">
            <h5 class="mb-0 h6 border-bottom border-primary border-width-2 py-4">{{ translate('Download Your Product') }}</h5>
        </div>
        <div class="card-body">
          <table class="table plx-table mb-0">
              <thead>
                  <tr>
                      <th>{{ translate('Product')}}</th>
                      <th width="20%" class="text-right">{{ translate('Option')}}</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($orders as $key => $order_id)
                      @php
                          $order = \App\Models\OrderDetail::find($order_id->id);
                      @endphp
                      <tr>
                          <td><a href="{{ route('product', $order->product->slug) }}">{{ $order->product->getTranslation('name') }}</a></td>
                          <td class="text-right">
                            <a class="btn btn-action-button btn-icon btn-sm" href="{{route('digitalproducts.download', encrypt($order->product->id))}}" title="{{ translate('Download') }}">
                                <i class="las la-download"></i>
                            </a>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
            {{ $orders->links() }}
        </div>
    </div>
@endsection
