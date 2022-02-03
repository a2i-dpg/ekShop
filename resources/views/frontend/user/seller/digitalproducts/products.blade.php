@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="row gutters-10 justify-content-center">
        @if (addon_is_activated('seller_subscription'))
            <div class="col-md-4 mx-auto mb-3" >
                <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                  <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                      <i class="las la-upload la-2x text-white"></i>
                  </span>
                  <div class="px-3 pt-3 pb-3">
                      <div class="h4 fw-700 text-center">{{ max(0, Auth::user()->seller->remaining_digital_uploads) }}</div>
                      <div class="opacity-50 text-center">{{  translate('Remaining Uploads') }}</div>
                  </div>
                </div>
            </div>
        @endif

        @if (addon_is_activated('seller_subscription'))
        @php
            $seller_package = \App\Models\SellerPackage::find(Auth::user()->seller->seller_package_id);
        @endphp
            <div class="col-md-4">
                <a href="{{ route('seller_packages_list') }}" class="text-center bg-white shadow-sm hov-shadow-lg text-center d-block p-3 rounded">
                    @if($seller_package != null)
                        <img src="{{ uploaded_asset($seller_package->logo) }}" height="44" class="mw-100 mx-auto">
                        <span class="d-block sub-title mb-2">{{ translate('Current Package')}}: {{ $seller_package->getTranslation('name') }}</span>
                    @else
                        <i class="la la-frown-o mb-2 la-3x"></i>
                        <div class="d-block sub-title mb-2">{{ translate('No Package Found')}}</div>
                    @endif
                    <div class="btn btn-outline-primary py-1">{{ translate('Upgrade Package')}}</div>
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header py-0">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="section-title border-bottom border-primary border-width-2 py-4">{{ translate('All Products') }}</div>
                <a href="{{ route('seller.digitalproducts.upload')}}" class="btn btn-primary btn-md h-100 px-2">{{ translate('Add New Digital Product') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table plx-table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="30%">{{ translate('Name')}}</th>
                        <th data-breakpoints="md">{{ translate('Category')}}</th>
                        <th data-breakpoints="md" class="text-nowrap">{{ translate('Base Price')}}</th>
                        <th data-breakpoints="md">{{ translate('Published')}}</th>
                        <th data-breakpoints="md">{{ translate('Featured')}}</th>
                        <th class="text-right">{{ translate('Options')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td><a href="{{ route('product', $product->slug) }}" target="_blank">{{   $product->getTranslation('name')  }}</a></td>
                            <td>
                                @if ($product->category != null)
                                    {{ $product->category->getTranslation('name') }}
                                @endif
                            </td>
                            <td>{{ $product->unit_price }}</td>
                            <td><label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->published == 1) echo "checked";?> >
                                    <span class="slider round"></span></label>
                            </td>
                            <td><label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->featured == 1) echo "checked";?> >
                                    <span class="slider round"></span></label>
                            </td>
                            <td class="text-right text-nowrap">
                                <a href="{{route('seller.digitalproducts.edit',  ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" class="btn btn-action-button btn-icon btn-circle btn-sm" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('digitalproducts.download', encrypt($product->id))}}" title="{{ translate('Download') }}">
                                    <i class="las la-download"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('digitalproducts.destroy', $product->id)}}" title="{{ translate('Delete') }}">
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
        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    PLX.plugins.notify('success', '{{ translate('Featured products updated successfully') }}');
                }
                else{
                    PLX.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    PLX.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                }
                else{
                    PLX.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
