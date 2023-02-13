<div>
    <div class="row">
        <div class="col-lg-11 mt-3 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="header-title text-center mb-4" style="font-size:25px">Add User</h2>
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {!! session('message') !!}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {!! session('error') !!}
                        </div>
                    @endif
                    <form wire:submit.prevent="user_save" method="POST">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="user_name" class="form-label">User Name <span class="text-danger">*</span>
                                    (<small>unique</small>) </label>
                                <input name='user_name' type="text" class="form-control" id="user_name"
                                    placeholder="Enter User Name" value="{{ old('user_name') }}" wire:model='user_name'
                                    required>
                                @error('user_name')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="user_full_name" class="form-label">Full Name</label>
                                <input name='user_full_name' type="text" class="form-control" id="user_full_name"
                                    placeholder="Enter Full Name" value="{{ old('user_full_name') }}"
                                    wire:model='user_full_name'>
                                @error('user_full_name')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="user_mobile_no" class="form-label">Mobile Number <span
                                        class="text-danger">*</span> (<small>unique</small>)</label>
                                <input name="user_mobile_no" type="text" class="form-control" id="user_mobile_no"
                                    placeholder="Enter Mobile Number" value="{{ old('user_mobile_no') }}"
                                    wire:model='user_mobile_no' required>
                                @error('user_mobile_no')
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
                                <label for="email" class="form-label">Email Address <span
                                        class="text-danger">*</span> (<small>unique</small>) </label>
                                <input name="email" type="email" class="form-control" id="email"
                                    placeholder="Enter email address" value="{{ old('email') }}" wire:model='email'
                                    required>
                                @error('email')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <input name="password" type="{{ $passwordType }}" class="form-control"
                                        id="password" placeholder="Enter password" value="{{ old('password') }}"
                                        wire:model='password' required>

                                    <div id="passEye" class="input-group-text" style="cursor: pointer;"
                                        wire:click='setPassType()'>
                                        <span class="password-eye"></span>
                                    </div>
                                </div>

                                @error('password')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="user_role" class="form-label">Role <span
                                        class="text-danger">*</span></label>
                                <select name="user_role" class="form-control" id="user_role" placeholder="Enter role"
                                    wire:model='user_role' required>
                                    
                                    @if ($authUser->role_id == App\Helpers\Variables::superAdminRole)
                                        <option value="{{ null }}" selected>select role</option>
                                        @foreach ($admin_agent_roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ $agentRole->id }}" selected>{{$agentRole->role_name}}</option>
                                    @endif

                                </select>
                                {{-- <input name="user_role" type="text" class="form-control" id="user_role" placeholder="Enter role" value="{{ old('user_role') }}"
                                wire:model = 'user_role'> --}}
                                @error('user_role')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add User</button>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</div>
