@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="card">
        <div class="card-header py-0">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="section-title border-bottom border-primary border-width-2 py-4 d-inline-block w-auto">{{translate('Tickets')}}</div>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#ticket_modal" class="btn btn-primary btn-md h-100 px-2">{{ translate('Add New Digital Product') }}</a>
            </div>
        </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table plx-table mb-0">
                      <thead>
                      <tr>
                          <th data-breakpoints="lg">{{ translate('Ticket ID') }}</th>
                          <th data-breakpoints="lg">{{ translate('Sending Date') }}</th>
                          <th>{{ translate('Subject')}}</th>
                          <th>{{ translate('Status')}}</th>
                          <th data-breakpoints="lg">{{ translate('Options')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach ($tickets as $key => $ticket)
                          <tr>
                              <td>#{{ $ticket->code }}</td>
                              <td>{{ $ticket->created_at }}</td>
                              <td>{{ $ticket->subject }}</td>
                              <td>
                                  @if ($ticket->status == 'pending')
                                      <span class="badge badge-inline badge-danger">{{ translate('Pending')}}</span>
                                  @elseif ($ticket->status == 'open')
                                      <span class="badge badge-inline badge-secondary">{{ translate('Open')}}</span>
                                  @else
                                      <span class="badge badge-inline badge-success">{{ translate('Solved')}}</span>
                                  @endif
                              </td>
                              <td>
                                  <a href="{{route('support_ticket.show', encrypt($ticket->id))}}" class="btn btn-styled btn-link py-1 px-0 icon-anim text-underline--none">
                                      {{ translate('View Details')}}
                                      <i class="la la-angle-right text-sm"></i>
                                  </a>
                              </td>
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
                  <div class="plx-pagination">
                      {{ $tickets->links() }}
                  </div>
              </div>
          </div>
    </div>
@endsection

@section('modal')
<div class="modal fade" id="ticket_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title strong-600 heading-5">{{ translate('Create a Ticket')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body px-3 pt-3">
                  <form class="" action="{{ route('support_ticket.store') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                          <div class="col-md-2">
                              <label>{{ translate('Subject')}}</label>
                          </div>
                          <div class="col-md-10">
                              <input type="text" class="form-control mb-3" placeholder="{{ translate('Subject')}}" name="subject" required>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-2">
                              <label>{{ translate('Provide a detailed description')}}</label>
                          </div>
                          <div class="col-md-10">
                              <textarea type="text" class="form-control mb-3" rows="3" name="details" placeholder="{{ translate('Type your reply')}}" data-buttons="bold,underline,italic,|,ul,ol,|,paragraph,|,undo,redo" required></textarea>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2 col-form-label">{{ translate('Photo') }}</label>
                          <div class="col-md-10">
                              <div class="input-group" data-toggle="plxuploader" data-type="image" data-multiple="true">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                  </div>
                                  <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                  <input type="hidden" name="attachments" class="selected-files">
                              </div>
                              <div class="file-preview box sm">
                              </div>
                          </div>
                      </div>
                      <div class="text-right mt-4">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('cancel')}}</button>
                          <button type="submit" class="btn btn-primary">{{ translate('Send Ticket')}}</button>
                      </div>
                  </form>
              </div>
            </div>
        </div>
    </div>
@endsection
