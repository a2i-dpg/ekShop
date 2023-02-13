<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">My Account</li>
                    </ol>
                </div>
                <h4 class="page-title">My Account</h4>
                @if (session()->has('delete'))
                    <div class="alert alert-danger">
                        {{ session('delete') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <style>
                .image_profile{
                    width: 150px;
                    height:150px;
                    margin:0 auto;
                }
                .profile_name h2{
                    font-size: 16px;
                    font-weight: 700;
                    text-align: center;
                }
                .profile_name h2 span{
                    font-size: 14px;
                    font-weight: 400;
                }
            </style>
            <div class="card">
                <div class="card-body">
                    <div class="image_profile">
                        <img src="{{ asset('') }}assets/theme/images/user-profile.png" alt="" width="150">
                    </div>
                    <div class="profile_name">
                        <h2>User Name: <span>{{ $accountInfo->user_name }}</span></h2>
                        <h2>Conatct Number: <span>{{ $accountInfo->user_mobile_no }}</span></h2>
                        <h2>Email: <span>{{ $accountInfo->email }}</span></h2>
                        <h2>Address: <span>
                            @if ($accountInfo->user_address)
                            {{ $accountInfo->user_address }}
                            @else
                               N/A 
                            @endif
                            </span></h2>
                        <h2>Role: <span>{{ $accountInfo->role->role_name }}</span></h2>
                        <div class="change_pass d-flex justify-content-between">
                            <a href="{{ route('common.changePassword') }}" class=" btn btn-danger mt-2">Change Password</a>
                            <a wire:click.prevent="userFind()" class=" btn btn-success mt-2" data-bs-toggle="modal"
                            data-bs-target="#userEdit">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal -->
     <div wire:ignore.self class="modal fade" id="userEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Company Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <form wire:submit.prevent="user_update" method="POST">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="user_name" class="form-label">user Name</label>
                            <input name='user_name' type="text" class="form-control" id="user_name" readonly wire:model = 'user_name'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="user_full_name" class="form-label">Full Name</label>
                            <input name='user_full_name' type="text" placeholder="Enater Full Name" class="form-control" id="user_full_name" wire:model = 'user_full_name'>
                            @error('user_full_name')
                                <span class=" text-small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="user_mobile_no" class="form-label">Mobile Number</label>
                            <input name="user_mobile_no" type="text" class="form-control" id="user_mobile_no" placeholder="Mobile Number" wire:model = 'user_mobile_no'>
                            @error('user_mobile_no')
                            <span class=" text-small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="user_address" class="form-label">Address</label>
                            <input name="user_address" type="text" class="form-control" id="user_address" placeholder="User address" wire:model = 'user_address'>
                            @error('user_address')
                            <span class=" text-small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Email" wire:model = 'email'>
                            @error('email')
                            <span class=" text-small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Update Profile</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
