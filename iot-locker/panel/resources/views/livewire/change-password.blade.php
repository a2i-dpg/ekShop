<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">My Account</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
                <h4 class="page-title">My account setting</h4>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form wire:submit.prevent="change_password" method="POST">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="user_full_name" class="form-label">New Password</label>
                                    <input name='new_password' type="password" class="form-control" id="new_password" placeholder="Enter New Password" wire:model = 'new_password'>
                                    @error('new_password')
                                        <span class=" text-small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input name="confirm_password" type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" wire:model = 'confirm_password'>
                                    @error('confirm_password')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
