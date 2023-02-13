<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                        <li class="breadcrumb-item active">Admin List</li>
                    </ol>
                </div>
                <h4 class="page-title">Admin List</h4>
                @if (session()->has('delete'))
                    <div class="alert alert-danger">
                        {{ session('delete') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <div class="filter">
                                <select name="" id="" class=" form-select"
                                    wire:model="deliveryManOrderBy">
                                    <option value="id">ID</option>
                                    <option value="user_full_name">Name</option>
                                    <option value="user_mobile_no">Mobile Number</option>
                                    <option value="email">Email</option>
                                    <option value="user_address">Address</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="asc_desc">
                                    <option value="1">Ascending</option>
                                    <option value="0">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 col-6 d-flex align-items-center gap-2">
                            <button wire:click="deliveryManDataExport"
                                class=" btn btn-sm btn-outline-purple">Export</button>
                        </div>
                        <div class="col-md-6 col-6 d-flex align-items-center justify-content-end gap-2">
                            @if ($this->authUser->role_id == App\Helpers\Variables::superAdminRole)
                                <a href="{{ route('admin.addAgent') }}" class="btn btn-sm btn-outline-purple">Add New</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-2 px-3">
                    <div class="col-md-2 col-4">
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

                    <div class="offset-md-6 col-md-4 col-8">
                        <div class="search">
                            <input type="text" wire:model.debounce.300ms='deliveryMan_search_text'
                                placeholder="Type anything for search" class=" form-control">
                        </div>
                    </div>
                </div>
                <div id="deliveryman_wrap" class="card-body table-responsive">
                    <table id="deliveryMan_all" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>User Status</th>
                                @if ($authUser->role_id == App\Helpers\Variables::superAdminRole)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($deliveryMan as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $data->user_full_name }}</td>
                                    <td>{{ $data->user_mobile_no }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->user_address }}</td>
                                    @if ($data->user_is_active === 1)
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge bg-soft-warning text-warning">Suspend<span>
                                        </td>
                                    @endif
                                    @if ($authUser->role_id == App\Helpers\Variables::superAdminRole)
                                        <td>
                                            <button wire:click="deliveryManEdit({{ $data->id }})"
                                                class=" btn btn-xs btn-info companyEdit" data-bs-toggle="modal"
                                                data-bs-target="#deliveryManEdit"><i class="fas fa-edit"></i></button>
                                            <button type="button" wire:click="adminDeleteId({{ $data->id }})"
                                                class=" btn btn-xs btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"><i class="fas fa-trash"></i></button>
                                        </td>
                                    @endif
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $deliveryMan->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    {{-- Company edit Modal form --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="deliveryManEdit" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Admin Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateDeliveryMan" method="POST">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="user_name" class="form-label">Username</label>
                                <input name='user_name' type="text" class="form-control" id="user_name"
                                    placeholder="Enter New Username" value="{{ old('user_name') }}"
                                    wire:model='user_name'>
                                @error('user_name')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="user_full_name" class="form-label">Full Name</label>
                                <input name='user_full_name' type="text" class="form-control" id="user_full_name"
                                    placeholder="Enter Full Name" value="{{ old('user_full_name') }}"
                                    wire:model='user_full_name' readonly>
                                @error('user_full_name')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="user_mobile_no" class="form-label">Mobile Number</label>
                                <input name="user_mobile_no" type="text" class="form-control" id="user_mobile_no"
                                    placeholder="Enter Mobile Number" value="{{ old('user_mobile_no') }}"
                                    wire:model='user_mobile_no'>
                                @error('user_mobile_no')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input name="email" type="email" class="form-control" id="email"
                                    placeholder="Enter email address" value="{{ old('email') }}"
                                    wire:model='email'>
                                @error('email')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="user_address" class="form-label">Address</label>
                                <input name="user_address" type="text" class="form-control" id="user_address"
                                    placeholder="Enter Address" value="{{ old('user_address') }}"
                                    wire:model='user_address'>
                                @error('user_address')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="user_password" class="form-label">Change Password</label>
                                <input name="user_password" type="text" class="form-control" id="user_password"
                                    placeholder="Enter New Password" value="{{ old('user_password') }}"
                                    wire:model='user_password'>
                                @error('user_password')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="user_is_active" class="form-label">Change Status</label>
                                <select name="user_is_active" id="user_is_active" wire:model='user_is_active'
                                    class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Suspend</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="adminDelete()" class="btn btn-danger close-modal"
                        data-bs-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>
@section('custom_script')
@endsection
