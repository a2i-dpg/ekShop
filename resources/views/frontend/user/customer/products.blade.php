@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="plx-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Products') }}</h1>
        </div>
      </div>
    </div>

    <div class="row gutters-10">
        <div class="col-lg-4 col-md-6 col-sm-12 mx-auto" >
            <div class="bg-dash-item d-flex justify-content-between rounded-10 hov-shadow-lg mb-4 overflow-hidden py-3">
                <div class="px-3 pt-3">
                    <div class="bg-dash-item-title-user">
                        <span class="d-block bg-dash-item-title-user">Remaining</span>
                        Uploads
                    </div>
                </div>
                <div class="p-3 d-flex justify-content-end align-items-end">
                    <div class="h3 fw-600 mr-3">
                        {{ max(0, Auth::user()->remaining_uploads) }}
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="69" viewBox="0 0 56 69" fill="none">
                        <rect y="0.00012207" width="55.8788" height="68.8263" rx="10.2217" fill="#92278F" fill-opacity="0.1"/>
                        <path d="M33.3332 39.3335L27.9998 34.0001L22.6665 39.3335" stroke="#92278F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M28 34.0001V46.0001" stroke="#92278F" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M38.8604 44.5168C40.1609 43.8079 41.1882 42.686 41.7803 41.3283C42.3723 39.9707 42.4954 38.4545 42.1301 37.0191C41.7647 35.5837 40.9318 34.3109 39.7627 33.4014C38.5936 32.492 37.1549 31.9978 35.6738 31.9968H33.9938C33.5902 30.4358 32.838 28.9866 31.7937 27.7582C30.7494 26.5297 29.4402 25.554 27.9646 24.9043C26.4889 24.2547 24.8852 23.948 23.2739 24.0074C21.6627 24.0667 20.0859 24.4906 18.662 25.2471C17.2382 26.0036 16.0043 27.073 15.0533 28.375C14.1022 29.6769 13.4587 31.1776 13.1711 32.764C12.8835 34.3505 12.9592 35.9816 13.3927 37.5345C13.8262 39.0875 14.6061 40.522 15.6738 41.7302" stroke="#92278F" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>

        @php
            $customer_package = \App\Models\CustomerPackage::find(Auth::user()->customer_package_id);
        @endphp
        <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
            <a href="{{ route('customer_packages_list_show') }}">
                <div class="bg-dash-item d-flex justify-content-between flex-column rounded-10 hov-shadow-lg mb-4 overflow-hidden py-3">
                    <div class="d-flex justify-content-between position-relative">
                        <div class="px-3 pt-3">
                            @if($customer_package != null)
                                <img src="{{ uploaded_asset($customer_package->logo) }}" height="44" class="mw-100 mx-auto">
                                <span class="d-block sub-title mb-2"></span>
                                <div class="bg-dash-item-title">
                                    <span class="d-block bg-dash-item-title-user">{{ translate('Current Package')}}: {{ $customer_package->getTranslation('name') }}</span>
                                </div>
                            @else
                                <div class="bg-dash-item-title">
                                    <span class="d-block bg-dash-item-title-user">{{ translate('No Package')}} <br>{{ translate('Found')}}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-3 d-flex justify-content-end align-items-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="69" viewBox="0 0 56 69" fill="none">
                                <rect y="0.00012207" width="55.8788" height="68.8263" rx="10.2217" fill="#92278F" fill-opacity="0.1"/>
                                <path d="M28 29.3335C33.799 29.3335 38.5 27.7665 38.5 25.8335C38.5 23.9005 33.799 22.3335 28 22.3335C22.201 22.3335 17.5 23.9005 17.5 25.8335C17.5 27.7665 22.201 29.3335 28 29.3335Z" stroke="#92278F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M38.5 34.0001C38.5 35.9368 33.8333 37.5001 28 37.5001C22.1667 37.5001 17.5 35.9368 17.5 34.0001" stroke="#92278F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.5 25.8335V42.1668C17.5 44.1035 22.1667 45.6668 28 45.6668C33.8333 45.6668 38.5 44.1035 38.5 42.1668V25.8335" stroke="#92278F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="upgrade-package-button">
                            {{ translate('Upgrade Package')}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mx-auto" >
            <a href="{{ route('customer_products.create')}}">
                <div class="bg-dash-item bg-base-user-product d-flex justify-content-start align-items-center rounded-10 hov-shadow-lg mb-4 overflow-hidden py-3">
                    <div class="p-3 d-flex justify-content-end align-items-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                            <path d="M56 28C56 43.464 43.464 56 28 56C12.536 56 0 43.464 0 28C0 12.536 12.536 0 28 0C43.464 0 56 12.536 56 28Z" fill="#92278F" fill-opacity="0.1"/>
                            <path d="M28 15.1666V40.8333" stroke="#92278F" stroke-width="3" stroke-linecap="round"/>
                            <path d="M15.167 28H40.8337" stroke="#92278F" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="px-3">
                        <div class="bg-dash-item-title">
                            <span class="d-block bg-dash-item-title-user text-primary">Add New Product</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header py-0">
            <div class="col text-center text-md-left border-bottom">
                <div class="section-title border-bottom border-primary border-width-2 py-3 d-inline-block w-auto">{{ translate('All Products') }}</div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table plx-table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Name')}}</th>
                        <th data-breakpoints="lg">{{ translate('Price')}}</th>
                        <th data-breakpoints="lg" class="text-nowrap">{{ translate('Available Status')}}</th>
                        <th data-breakpoints="lg" class="text-nowrap">{{ translate('Admin Status')}}</th>
                        <th class="text-right">{{ translate('Options')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td><a href="{{ route('customer.product', $product->slug) }}">{{ $product->name }}</a></td>
                            <td>{{ single_price($product->unit_price) }}</td>
                            <td><label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_status(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->status == 1) echo "checked";?> >
                                    <span class="slider round"></span></label>
                            </td>
                            <td>
                                @if ($product->published == '1')
                                    <span class="badge badge-inline badge-success">{{ translate('PUBLISHED')}}</span>
                                @else
                                    <span class="badge badge-inline badge-info">{{ translate('PENDING')}}</span>
                                @endif
                            </td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-action-button btn-icon btn-sm" href="{{route('customer_products.edit', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                
                                <a href="javascript:void(0)" class="btn btn-action-button btn-icon btn-sm confirm-delete" data-href="{{route('customer_products.destroy', $product->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="plx-pagination">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

        function update_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('customer_products.update.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    PLX.plugins.notify('success', '{{ translate('Status has been updated successfully') }}');
                }
                else{
                    PLX.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

    </script>
@endsection
