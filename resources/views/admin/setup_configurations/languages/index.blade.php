@extends('admin.layouts.app')

@section('content')
    <div class="plx-titlebar text-left mt-2">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{ translate('Configurations') }}</h1>
            </div>
        </div>
    </div>
    <br>
<div class="row">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 section-title">{{ translate('Default Language') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Default Language') }}</label>
                        </div>
                        <input type="hidden" name="types[]" value="DEFAULT_LANGUAGE">
                        <div class="col-lg-6">
                            <select class="form-control demo-select2-placeholder" name="DEFAULT_LANGUAGE">
                                @foreach (\App\Models\Language::all() as $key => $language)
                                    <option value="{{ $language->code }}" <?php if(env('DEFAULT_LANGUAGE') == $language->code) echo 'selected'?> >{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Import App Translations') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('app-translations.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('English Trasnlation File') }}</label>
                        </div>
                        <div class="col-lg-6">
                            <div class="custom-file">
                                <label class="custom-file-label">
                                    <input type="file" id="lang_file" name="lang_file"  class="custom-file-input" required>
                                    <span class="custom-file-name">{{ translate('Choose app_en.arb file') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary">{{translate('Import')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="plx-titlebar text-left mt-4 mb-3">
	<div class="align-items-center">
		<div class="text-md-right">
			<a href="{{ route('languages.create') }}" class="btn btn-primary">
				<span>{{translate('Add New Language')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Language')}}</h5>
    </div>
    <div class="card-body">
        <table class="table plx-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Code')}}</th>
                    <th data-breakpoints="lg">{{translate('Flutter App Lang Code')}}</th>
                    <th data-breakpoints="lg">{{translate('RTL')}}</th>
                    <th class="text-right" width="15%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($languages as $key => $language)
                    <tr>
                        <td>{{ ($key+1) + ($languages->currentPage() - 1)*$languages->perPage() }}</td>
                        <td>{{ $language->name }}</td>
                        <td>{{ $language->code }}</td>
                        <td>{{ $language->app_lang_code }}</td>
                        <td><label class="plx-switch plx-switch-success mb-0">
                            <input onchange="update_rtl_status(this)" value="{{ $language->id }}" type="checkbox" <?php if($language->rtl == 1) echo "checked";?> >
                            <span class="slider round"></span></label>
                        </td>
                        <td class="text-right text-nowrap">
                            <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('languages.show', $language->id)}}" title="{{ translate('Translation') }}">
                                <i class="las la-language"></i>
                            </a>
                            <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('app-translations.show', $language->id)}}" title="{{ translate('App Translation') }}">
                                <i class="las la-language"></i>
                            </a>
                            <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('app-translations.export', $language->id)}}" title="{{ translate('arb File Export') }}" download>
                                <i class="las la-download"></i>
                            </a>
                            <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('languages.edit', $language->id)}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            @if($language->code != 'en')
                                <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('languages.destroy', $language->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <div class="plx-pagination">
            {{ $languages->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_rtl_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('languages.update_rtl_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    location.reload();
                }
                else{
                    PLX.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
