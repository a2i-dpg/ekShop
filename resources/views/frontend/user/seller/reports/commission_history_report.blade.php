@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card">
        @include('admin.reports.partials.commission_history_section')
    </div>
@endsection
