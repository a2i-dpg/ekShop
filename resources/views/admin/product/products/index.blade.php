@extends('admin.layouts.app')

@section('content')

<div class="plx-titlebar text-left mt-2">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('products')}}</h1>
        </div>
        @if($type != 'Seller')
            <div class="col text-right">
                <a href="{{ route('products.create') }}" class="btn btn-create">
                    <span>{{translate('Add New Product')}}</span>
                </a>
            </div>
        @endif
    </div>
</div>
<br>

<div class="card">
    <form class="" id="sort_products" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="section-title mb-0">{{ translate('All Product') }}</h5>
            </div>

            <div class="col-md-2 ml-auto">
                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn bulk-action-product border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{translate('Bulk Action')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" onclick="bulk_delete()"> {{translate('Delete selection')}}</a>
                    </div>
                </div>
            </div>

            @if($type == 'Seller')
                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm plx-selectpicker mb-2 mb-md-0" id="user_id" name="user_id" onchange="sort_products()">
                        <option value="">{{ translate('All Sellers') }}</option>
                        @foreach (App\Models\Seller::all() as $key => $seller)
                            @if ($seller->user != null && $seller->user->shop != null)
                                <option value="{{ $seller->user->id }}" @if ($seller->user->id == $seller_id) selected @endif>{{ $seller->user->shop->name }} ({{ $seller->user->name }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @endif
            @if($type == 'All')
                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm plx-selectpicker mb-2 mb-md-0" id="user_id" name="user_id" onchange="sort_products()">
                        <option value="">{{ translate('All Sellers') }}</option>
                        @foreach (App\Models\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get() as $key => $seller)
                            <option value="{{ $seller->id }}" @if ($seller->id == $seller_id) selected @endif>{{ $seller->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="col-md-2 ml-auto">
                <select class="form-control form-control-sm plx-selectpicker mb-2 mb-md-0" name="type" id="type" onchange="sort_products()">
                    <option value="">{{ translate('Sort By') }}</option>
                    <option value="rating,desc" @isset($col_name , $query) @if($col_name == 'rating' && $query == 'desc') selected @endif @endisset>{{translate('Rating (High > Low)')}}</option>
                    <option value="rating,asc" @isset($col_name , $query) @if($col_name == 'rating' && $query == 'asc') selected @endif @endisset>{{translate('Rating (Low > High)')}}</option>
                    <option value="num_of_sale,desc"@isset($col_name , $query) @if($col_name == 'num_of_sale' && $query == 'desc') selected @endif @endisset>{{translate('Num of Sale (High > Low)')}}</option>
                    <option value="num_of_sale,asc"@isset($col_name , $query) @if($col_name == 'num_of_sale' && $query == 'asc') selected @endif @endisset>{{translate('Num of Sale (Low > High)')}}</option>
                    <option value="unit_price,desc"@isset($col_name , $query) @if($col_name == 'unit_price' && $query == 'desc') selected @endif @endisset>{{translate('Base Price (High > Low)')}}</option>
                    <option value="unit_price,asc"@isset($col_name , $query) @if($col_name == 'unit_price' && $query == 'asc') selected @endif @endisset>{{translate('Base Price (Low > High)')}}</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control form-control-sm" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & Enter') }}">
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table plx-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 20px;">
                                <div class="form-group">
                                    <div class="plx-checkbox-inline">
                                        <label class="plx-checkbox">
                                            <input type="checkbox" class="check-all" id="checkAllBulkDelete"/>
                                            <span class="plx-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                            <th>{{translate('')}}</th>
                            <th>{{translate('Name')}}</th>
                            <th>{{translate('Category')}}</th>
                            <th data-breakpoints="sm" class="text-nowrap">{{translate('Rating ')}}
                                <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" width="11" height="15" viewBox="0 0 11 15" fill="none">
                                    <path d="M5.5 14L5.5 1M5.5 1L1 5.60788M5.5 1L10 5.60788" stroke="#92278F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </th>
                            <th data-breakpoints="sm" class="text-nowrap">{{translate('Price ')}}
                                <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" width="11" height="15" viewBox="0 0 11 15" fill="none">
                                    <path d="M5.5 14L5.5 1M5.5 1L1 5.60788M5.5 1L10 5.60788" stroke="#3D3D3D" stroke-opacity="0.26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </th>
                            <th data-breakpoints="sm" class="text-nowrap">{{translate('Num of Sale ')}}
                                <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" width="11" height="15" viewBox="0 0 11 15" fill="none">
                                    <path d="M5.5 14L5.5 1M5.5 1L1 5.60788M5.5 1L10 5.60788" stroke="#3D3D3D" stroke-opacity="0.26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </th>
                            <th data-breakpoints="md" class="text-nowrap">{{translate('Total Stock')}}</th>
                            <th data-breakpoints="lg" class="text-nowrap">{{translate('Todays Deal')}}</th>
                            <th data-breakpoints="lg">{{translate('Published')}}</th>
                            @if(get_setting('product_approve_by_admin') == 1 && $type == 'Seller')
                                <th data-breakpoints="lg">{{translate('Approved')}}</th>
                            @endif
                            <th data-breakpoints="lg">{{translate('Featured')}}</th>
                            <th data-breakpoints="sm" class="text-right checked-bulk-selection-delete">{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td>
                                <div class="form-group d-inline-block">
                                    <label class="plx-checkbox">
                                        <input type="checkbox" class="check-one" name="id[]" value="{{$product->id}}">
                                        <span class="plx-square-check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="product-thumb">
                                    <img src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image" class="size-50px img-fit" />
                                </div>
                            </td>
                            <td>
                                <span class="text-muted text-truncate-2" style="max-width: 160px">{{ $product->getTranslation('name') }}</span>
                            </td>
                            <td>
                                <span class="text-muted text-truncate-2" style="max-width: 100px">Indoor Plant</span>
                            </td>
                            <td>
                                <span class="text-muted text-truncate-2">{{ $product->rating }}</span>
                            </td>
                            <td>
                                <span class="text-muted text-truncate-2">{{ single_price($product->unit_price) }}</span>
                            </td>
                            <td>
                                <span class="text-muted text-truncate-2">{{ $product->num_of_sale }}</span>
                            </td>
                            <td>
                                @php
                                    $qty = 0;
                                    if($product->variant_product) {
                                        foreach ($product->stocks as $key => $stock) {
                                            $qty += $stock->qty;
                                            echo $stock->variant.' - '.$stock->qty.'<br>';
                                        }
                                    }
                                    else {
                                        $qty = optional($product->stocks->first())->qty;
                                        echo $qty;
                                    }
                                @endphp
                                @if($qty <= $product->low_stock_quantity)
                                    <span class="badge badge-inline badge-danger">Low</span>
                                @endif
                            </td>
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_todays_deal(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->todays_deal == 1) echo "checked"; ?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->published == 1) echo "checked"; ?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            @if(get_setting('product_approve_by_admin') == 1 && $type == 'Seller')
                                <td>
                                    <label class="plx-switch plx-switch-success mb-0">
                                        <input onchange="update_approved(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->approved == 1) echo "checked"; ?> >
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            @endif
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->featured == 1) echo "checked"; ?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right text-nowrap checked-bulk-selection-delete">
                                <a class="btn btn-action-button btn-icon btn-rounded btn-sm" data-toggle="tooltip" data-placement="top" title="View" href="{{ route('product', $product->slug) }}" target="_blank" title="{{ translate('View') }}">
                                    <i class="las la-eye"></i>
                                </a>
                                @if ($type == 'Seller')
                                    <a class="btn btn-action-button btn-icon btn-rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" href="{{route('products.seller.edit', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @else
                                    <a class="btn btn-action-button btn-icon btn-rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" href="{{route('products.admin.edit', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @endif
                                <a class="btn btn-action-button btn-icon btn-rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Copy" href="{{route('products.duplicate', ['id'=>$product->id, 'type'=>$type]  )}}" title="{{ translate('Duplicate') }}">
                                    <i class="las la-copy"></i>
                                </a>
                                <a href="#" class="btn btn-action-button btn-icon btn-rounded btn-sm confirm-delete" data-toggle="tooltip" data-placement="top" title="Delete" data-href="{{route('products.destroy', $product->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="plx-pagination">
                    {{ $products->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">

        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        $(document).ready(function(){
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.todays_deal') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    PLX.plugins.notify('success', '{{ translate('Todays Deal updated successfully') }}');
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

        function update_approved(el){
            if(el.checked){
                var approved = 1;
            }
            else{
                var approved = 0;
            }
            $.post('{{ route('products.approved') }}', {
                _token      :   '{{ csrf_token() }}',
                id          :   el.value,
                approved    :   approved
            }, function(data){
                if(data == 1){
                    PLX.plugins.notify('success', '{{ translate('Product approval update successfully') }}');
                }
                else{
                    PLX.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

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

        function sort_products(el){
            $('#sort_products').submit();
        }

        function bulk_delete() {
            var data = new FormData($('#sort_products')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-product-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }

    </script>
    <script>
        $(document).ready(function(){
            $(".checked-bulk-selection-button").hide();
            $(".checked-bulk-selection-delete").show();
            $(".check-all").click(function() {
                if($(this).is(":checked")) {
                    $(".checked-bulk-selection-button").show();
                    $(".checked-bulk-selection-delete").hide();
                } else {
                    $(".checked-bulk-selection-button").hide();
                    $(".checked-bulk-selection-delete").show();
                }
            });
        });
    </script>
@endsection
