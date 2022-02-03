@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="plx-titlebar text-left mt-2">
            <h1 class="h3">{{translate('Color Information')}}</h1>
        </div>
        <br>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-0">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="p-4" action="{{ route('colors.update', $color->id) }}" method="POST">
                    <input name="_method" type="hidden" value="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">
                            {{ translate('Name')}}
                        </label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" required value="{{ $color->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="code">
                            {{ translate('Color Code')}}
                        </label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Color Code')}}" id="code" name="code" class="form-control" required value="{{ $color->code }}">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
