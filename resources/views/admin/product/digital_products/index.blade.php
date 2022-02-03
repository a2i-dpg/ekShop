@extends('admin.layouts.app')

@section('content')
    <div class="plx-titlebar text-left mt-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('Products')}}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('digitalproducts.create') }}" class="btn btn-create">
                    <span>{{translate('Add New Digital Product')}}</span>
                </a>
            </div>
        </div>
    </div>
    <br>

<div class="card">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Digital Products') }}</h5>
            </div>
            <div class="col-md-4">
                <form class="" id="sort_digital_products" action="" method="GET">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table plx-table mb-0">
                    <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th width="30%">{{translate('Name')}}</th>
                        <th data-breakpoints="lg">{{translate('Added By')}}</th>
                        <th data-breakpoints="lg">{{translate('Photo')}}</th>
                        <th data-breakpoints="lg">{{translate('Base Price')}}</th>
                        <th data-breakpoints="lg">{{translate('Todays Deal')}}</th>
                        <th data-breakpoints="lg">{{translate('Published')}}</th>
                        <th data-breakpoints="lg">{{translate('Featured')}}</th>
                        <th data-breakpoints="lg">{{translate('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                            <td><a href="{{ route('product', $product->slug) }}" class="text-muted" target="_blank"><b>{{ $product->getTranslation('name') }}</b></a></td>
                            <td>{{ ucfirst($product->added_by) }}</td>
                            <td>
                                <img src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image" class="w-50px">
                            </td>
                            <td>{{ number_format($product->unit_price,2) }}</td>
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_todays_deal(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->todays_deal == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->published == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->featured == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('digitalproducts.edit', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('digitalproducts.destroy', $product->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                                <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('digitalproducts.download', encrypt($product->id))}}" title="{{ translate('Download') }}">
                                    <i class="las la-download"></i>
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
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

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
    </script>
@endsection
