<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Add Api Secret</li>
                    </ol>
                </div>
                <h4 class="page-title">Api Secret</h4>
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mt-3 mx-auto">
            <div class="card">
                <div class="card-header p-1">
                    <h2 class=" text-center" style="font-size: 18px;font-weight:bold"> Add api header data</h2>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="apiSecret">
                        <div class="row">
                            <div class="mb-3 col-md-6" id="">
                                <label for="key_title" class="form-label">Secret Title</label>
                                <input name="key_title" type="text" class="form-control"  value="{{ old('key_title') }}" wire:model = 'key_title'>
                                @error('key_title')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6" id="api_auth">
                                <label for="api_auth" class="form-label">Api auth key</label>
                                <input name="key_title" type="text" class="form-control"  value="{{ old('api_auth') }}" wire:model = 'api_auth'>
                                @error('api_auth')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6" id="locker_id">
                                <label for="locker_id" class="form-label">Select Locker</label>
                               <select id="" class=" form-select" wire:model="locker_id">
                                   <option value="">Please select</option>
                                   @foreach ($allLocker as $item)
                                    <option value="{{ $item->locker_id }}">{{ $item->locker_id }}</option>
                                   @endforeach
                               </select>
                               @error('locker_id')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary" type="submit">Add Secret</button>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-11 mt-3 mx-auto">
            <div class="card">
                <h2 class=" text-center" style="font-size: 18px;font-weight:bold"> Api header data list</h2>
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="search">
                                <input type="text" wire:model.debounce.300ms='secret_search_text' placeholder="Type anything for search" class=" form-control">
                            </div>
                        </div>                        
                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="page_no">
                                    <option value=10>10</option>
                                    <option value=15>15</option>
                                    <option value=20>20</option>
                                    <option value=25>25</option>
                                    <option value=30>30</option>
                                    <option value=50>50</option>
                                    <option value=100>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="" wire:click.prevent = "clearSearch" class=" btn btn-danger">Clear</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="secret_all" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Secret Title</th>
                                <th>Locker</th>
                                <th>Secret Auth</th>
                                <th>Secret Key</th>
                                <th>Status</th>
                            </tr>
                        </thead>


                        <tbody>
                            @if ($allSecret)
                            @foreach ($allSecret as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <strong>Title: </strong><span>{{ $data->key_title }}</span><br>
                                    @if ($data->is_active === 1)
                                    <span wire:click="changeActive({{ $data->id }})" class="badge bg-soft-success text-success" style="cursor: pointer;">Active</span>
                                    @else
                                    <span wire:click="changeSuspend({{ $data->id }})" class="badge bg-soft-warning text-warning" style="cursor: pointer;">Suspend</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($data->locker_id)
                                    <strong>ID: </strong><span>{{ $data->locker_id }}</span><br>
                                    {{-- <strong>Address: </strong>{{ $data->locker->location_address }} --}}
                                    @else 
                                    N/A
                                    @endif
                                    
                                </td>
                                <td>{{ $data->api_auth }}</td>
                                <td>{{ $data->secret_api_key }}</td>
                                <td>
                                    <button wire:click="secretEdit({{ $data->id }})" class=" btn btn-xs btn-success" data-bs-toggle="modal" data-bs-target="#secretEdit"><i
                                        class="fas fa-edit"></i></button>
                                    <button wire:click="secretDelete({{ $data->id }})" class=" btn btn-xs btn-danger"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                                
                            </tr>
                        @endforeach
                        @endif     
                        </tbody>
                    </table>
                    {{ $allSecret->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
    </div>
      {{-- Booking view Modal form --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="secretEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Booking Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                    <p class=" alert alert-success">{{ session('message') }}</p>
                    @endif
                    @if (session()->has('error'))
                        <p class=" alert alert-danger">{{ session('error') }}</p>
                    @endif
                    <div class="card-body">
                        <form wire:submit.prevent = "secretUpdate({{ $current_id }})">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="key_title">Key Title</label>
                                    <input type="text" wire:model = "key_title_edit" class=" form-control">
                                    @error('key_title_edit')
                                        <span></span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="api_auth">Api auth title</label>
                                    <input type="text" wire:model = "api_auth_edit" class=" form-control">
                                </div>
                                <div class="mb-3 col-md-12" id="locker_id">
                                    <label for="locker_id" class="form-label">Select Locker</label>
                                   <select id="" class=" form-select" wire:model="locker_id_edit">
                                       <option value="">Please select</option>
                                       @foreach ($allLocker as $item)
                                        <option value="{{ $item->locker_id }}">{{ $item->locker_id }}</option>
                                       @endforeach
                                   </select>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="is_active">Change status</label>
                                    <select id="" class=" form-select" wire:model = 'is_active_edit'>
                                        <option value="0">Suspend</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-success btn-block">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
