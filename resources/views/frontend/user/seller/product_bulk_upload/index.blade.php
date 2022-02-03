@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="plx-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <div class="section-title">{{ translate('Bulk Products Upload') }}</div>
        </div>
      </div>
    </div>

    <div class="card shadow-none">
        <div class="card-body">
            <table class="table plx-table mb-0 rounded-10" style="font-size:14px; background-color: #FFE3FF; border-color: #FFE3FF">
                <tr>
                    <td class="border-top-0">{{ translate('1. Download the skeleton file and fill it with data.')}}:</td>
                </tr>
                <tr >
                    <td>{{ translate('2. You can download the example file to understand how the data must be filled.')}}:</td>
                </tr>
                <tr>
                    <td>{{ translate('3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.')}}:</td>
                </tr>
                <tr>
                    <td>{{ translate('4. After uploading products you need to edit them and set products images and choices.')}}</td>
                </tr>
            </table>
            <a href="{{ static_asset('download/product_bulk_demo.xlsx') }}" download><button class="btn btn-primary mt-2">{{ translate('Download CSV') }}</button></a>
        </div>
    </div>

    <div class="card shadow-none">
        <div class="card-body">
            <table class="table plx-table mb-0 rounded-10" style="font-size:14px;background-color: #FFE3FF;border-color: #FFE3FF">
                <tr>
                    <td class="border-top-0">{{ translate('1. Category and Brand should be in numerical id.')}}:</td>
                </tr>
                <tr >
                    <td>{{ translate('2. You can download the pdf to get Category and Brand id.')}}:</td>
                </tr>
            </table>
            <a href="{{ route('pdf.download_category') }}"><button class="btn btn-primary mt-2">{{ translate('Download Category')}}</button></a>
            <a href="{{ route('pdf.download_brand') }}"><button class="btn btn-primary mt-2">{{ translate('Download Brand')}}</button></a>
        </div>
    </div>

    <div class="card shadow-none">
        <div class="card-header">
            <div class="col text-center text-md-left">
                <h5 class="section-title py-2">{{ translate('Upload CSV File') }}</h5>
            </div>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('bulk_product_upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ translate('CSV') }}</label>
                    <div class="col-sm-10">
                        <div class="custom-file">
    						<label class="custom-file-label">
    							<input type="file" name="bulk_file" class="custom-file-input" required>
    							<span class="custom-file-name">{{ translate('Choose File')}}</span>
    						</label>
    					</div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Upload CSV')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
