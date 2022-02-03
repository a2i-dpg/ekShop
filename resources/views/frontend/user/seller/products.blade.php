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
                      <div class="h4 fw-700 text-center">{{ max(0, Auth::user()->seller->remaining_uploads) }}</div>
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

    <div class="card dashboard-cart-area mb-0">
        <div class="card-header border-bottom py-0">
            <h5 class="mb-0 h6 border-bottom border-primary border-width-2 py-4">{{ translate('Products') }}</h5>
        </div>
        <div class="card-header border-bottom">
            <a href="{{ route('seller.products.upload')}}" class="btn btn-primary btn-md text-nowrap mr-3">
               {{ translate('Add New Product') }}
            </a>
            <div class="input-group">
                <form action="" method="GET" class="w-100">
                    <input type="text" class="form-control w-100" id="search" name="search" @isset($search) value="{{ $search }}" @endisset placeholder="{{ translate('Search product') }}">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table plx-table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="25%">{{ translate('Name')}}</th>
                        <th data-breakpoints="md">{{ translate('Category')}}</th>
                        <th data-breakpoints="md" class="text-nowrap">{{ translate('Current Qty')}}</th>
                        <th class="text-nowrap">{{ translate('Base Price')}}</th>
                        <th data-breakpoints="md">{{ translate('Published')}}</th>
                        <th data-breakpoints="md">{{ translate('Featured')}}</th>
                        <th data-breakpoints="md" class="text-right">{{ translate('Options')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                            <td>
                                <a href="{{ route('product', $product->slug) }}" target="_blank" class="text-reset">
                                    {{ $product->getTranslation('name') }}
                                </a>
                            </td>
                            <td>
                                @if ($product->category != null)
                                    {{ $product->category->getTranslation('name') }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $qty = 0;
                                    foreach ($product->stocks as $key => $stock) {
                                        $qty += $stock->qty;
                                    }
                                    echo $qty;
                                @endphp
                            </td>
                            <td>{{ $product->unit_price }}</td>
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->published == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->seller_featured == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('seller.products.edit', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')])}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="{{route('products.duplicate', $product->id)}}" class="btn btn-action-button btn-icon btn-circle btn-sm"  title="{{ translate('Duplicate') }}">
                                    <i class="las la-copy"></i>
                                </a>
                                <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('products.destroy', $product->id)}}" title="{{ translate('Delete') }}">
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
            $.post('{{ route('products.seller.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
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
