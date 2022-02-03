@extends('admin.layouts.app')

@section('content')
    <div class="plx-titlebar text-left mt-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('Marketing')}}</h1>
            </div>
        </div>
    </div>
    <br>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 section-title">{{translate('All Subscribers')}}</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table plx-table mb-0">
                <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Email')}}</th>
                    <th data-breakpoints="lg">{{translate('Date')}}</th>
                    <th data-breakpoints="lg" class="text-right">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscribers as $key => $subscriber)
                    <tr>
                        <td>{{ ($key+1) + ($subscribers->currentPage() - 1)*$subscribers->perPage() }}</td>
                        <td><div class="text-truncate">{{ $subscriber->email }}</div></td>
                        <td>{{ date('d-m-Y', strtotime($subscriber->created_at)) }}</td>
                        <td class="text-right">
                            <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('subscriber.destroy', $subscriber->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pull-right">
                    {{ $subscribers->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
