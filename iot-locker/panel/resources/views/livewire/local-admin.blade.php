<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Add Local Admin</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Local Admin</h4>
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 mt-3">
            <div class="card">
                
                <div class="card-body">
                    <form wire:submit.prevent="addAdmin">
                        <div class="row">
                            <div class="mb-3 col-md-12" id="">
                                <label for="key_title" class="form-label">User Name</label>
                                <input name="user_name" type="text" class="form-control"  value="{{ old('user_name') }}" wire:model = 'user_name'>
                                @error('user_name')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="mb-3 col-md-12" id="api_auth">
                                <label for="api_auth" class="form-label">Admin Full Name</label>
                                <input name="user_full_name" type="text" class="form-control"  value="{{ old('user_full_name') }}" wire:model = 'user_full_name'>
                                @error('user_full_name')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <div class="mb-3 col-md-12" id="api_auth">
                                <label for="user_mobile_no" class="form-label">Mobile Number</label>
                                <input name="user_mobile_no" type="text" class="form-control"  value="{{ old('user_mobile_no') }}" wire:model = 'user_mobile_no'>
                                @error('user_mobile_no')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12" id="api_auth">
                                <label for="email" class="form-label">Email Address</label>
                                <input name="email" type="text" class="form-control"  value="{{ old('email') }}" wire:model = 'email'>
                                @error('email')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add Admin</button>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-8 mt-3">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="secret_all" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                                <th>Status</th>
                                
                            </tr>
                        </thead>


                        <tbody>
                            @if ($allAdmin)
                            @foreach ($allAdmin as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $data->user_name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->user_mobile_no }}</td>
                                <td>
                                    
                                    <button wire:click="adminDelete({{ $data->id }})" class=" btn btn-xs btn-danger"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                                @if ($data->user_is_active === 1)
                                    <td>
                                        <span class="badge bg-soft-success text-success">Active</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="badge bg-soft-warning text-warning">Suspend</span>
                                    </td>
                                @endif
                                
                            </tr>
                        @endforeach
                            @endif
                            
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
    </div>
</div>
@section('custom_script')
<script>
   $('#secret_all').DataTable({
       responsive:true
   })   
</script>
@endsection
