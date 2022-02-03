@extends('admin.layouts.app')

@section('content')
    <div class="plx-titlebar text-left mt-2">
        <div class="align-items-center">
            <div class="">
                <h1 class="h3">{{translate('Support')}}</h1>
            </div>
        </div>
    </div>
    <br>
<div class="card">
    <div class="card-header py-0">
        <div class="section-title border-bottom border-primary border-width-2 py-3 d-inline-block w-auto">{{translate('Conversations')}}</div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table plx-table mb-0" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th data-breakpoints="lg">{{ translate('Date') }}</th>
                    <th data-breakpoints="lg">{{translate('Title')}}</th>
                    <th>{{translate('Sender')}}</th>
                    <th>{{translate('Receiver')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($conversations as $key => $conversation)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $conversation->created_at }}</td>
                        <td>{{ $conversation->title }}</td>
                        <td>
                            @if ($conversation->sender != null)
                                {{ $conversation->sender->name }}
                                @if ($conversation->receiver_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($conversation->receiver != null)
                                {{ $conversation->receiver->name }}
                                @if ($conversation->sender_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-right">
                            <a class="btn btn-action-button btn-icon btn-circle btn-sm" href="{{route('conversations.admin_show', encrypt($conversation->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a href="#" class="btn btn-action-button btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('conversations.destroy', encrypt($conversation->id))}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
