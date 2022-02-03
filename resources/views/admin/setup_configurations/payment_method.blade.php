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

        <!--Bkash-->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header ">
                    <h5 class="section-title mb-0">{{translate('Bkash Credential')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="bkash">
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_APP_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('BKASH CHECKOUT APP KEY')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="BKASH_CHECKOUT_APP_KEY" value="{{  env('BKASH_CHECKOUT_APP_KEY') }}" placeholder="{{translate('BKASH CHECKOUT APP KEY')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_APP_SECRET">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('BKASH CHECKOUT APP SECRET')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="BKASH_CHECKOUT_APP_SECRET" value="{{  env('BKASH_CHECKOUT_APP_SECRET') }}" placeholder="{{translate('BKASH CHECKOUT APP SECRET')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_USER_NAME">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('BKASH CHECKOUT USER NAME')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="BKASH_CHECKOUT_USER_NAME" value="{{  env('BKASH_CHECKOUT_USER_NAME') }}" placeholder="{{translate('BKASH CHECKOUT USER NAME')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_PASSWORD">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('BKASH CHECKOUT PASSWORD')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="BKASH_CHECKOUT_PASSWORD" value="{{  env('BKASH_CHECKOUT_PASSWORD') }}" placeholder="{{translate('BKASH CHECKOUT PASSWORD')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('Bkash Sandbox Mode')}}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input value="1" name="bkash_sandbox" type="checkbox" @if (get_setting('bkash_sandbox') == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Nagad-->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="section-title mb-0 ">{{translate('Nagad Credential')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="nagad">
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="NAGAD_MODE">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('NAGAD MODE')}}</label>
                            </div>
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="NAGAD_MODE" value="{{  env('NAGAD_MODE') }}" placeholder="{{translate('NAGAD MODE')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="NAGAD_MERCHANT_ID">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('NAGAD MERCHANT ID')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="NAGAD_MERCHANT_ID" value="{{  env('NAGAD_MERCHANT_ID') }}" placeholder="{{translate('NAGAD MERCHANT ID')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="NAGAD_MERCHANT_NUMBER">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('NAGAD MERCHANT NUMBER')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="NAGAD_MERCHANT_NUMBER" value="{{  env('NAGAD_MERCHANT_NUMBER') }}" placeholder="{{translate('NAGAD MERCHANT NUMBER')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="NAGAD_PG_PUBLIC_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('NAGAD PG PUBLIC KEY')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="NAGAD_PG_PUBLIC_KEY" value="{{  env('NAGAD_PG_PUBLIC_KEY') }}" placeholder="{{translate('NAGAD PG PUBLIC KEY')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="NAGAD_MERCHANT_PRIVATE_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('NAGAD MERCHANT PRIVATE KEY')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="NAGAD_MERCHANT_PRIVATE_KEY" value="{{  env('NAGAD_MERCHANT_PRIVATE_KEY') }}" placeholder="{{translate('NAGAD MERCHANT PRIVATE KEY')}}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Sslcommerz-->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header ">
                    <h5 class="section-title mb-0">{{translate('Sslcommerz Credential')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="sslcommerz">
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="SSLCZ_STORE_ID">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('Sslcz Store Id')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="SSLCZ_STORE_ID" value="{{  env('SSLCZ_STORE_ID') }}" placeholder="{{translate('Sslcz Store Id')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="SSLCZ_STORE_PASSWD">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('Sslcz store password')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="SSLCZ_STORE_PASSWD" value="{{  env('SSLCZ_STORE_PASSWD') }}" placeholder="{{translate('Sslcz store password')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('Sslcommerz Sandbox Mode')}}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input value="1" name="sslcommerz_sandbox" type="checkbox" @if (get_setting('sslcommerz_sandbox') == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Aamarpay-->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header ">
                    <h5 class="section-title mb-0">{{translate('Aamarpay Credential')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="aamarpay">
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AAMARPAY_STORE_ID">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('Aamarpay Store Id')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="AAMARPAY_STORE_ID" value="{{  env('AAMARPAY_STORE_ID') }}" placeholder="{{translate('Aamarpay Store Id')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AAMARPAY_SIGNATURE_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('Aamarpay signature key')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="AAMARPAY_SIGNATURE_KEY" value="{{  env('AAMARPAY_SIGNATURE_KEY') }}" placeholder="{{translate('Aamarpay signature key')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{translate('Aamarpay Sandbox Mode')}}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="plx-switch plx-switch-success mb-0">
                                    <input value="1" name="aamarpay_sandbox" type="checkbox" @if (get_setting('aamarpay_sandbox') == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection
