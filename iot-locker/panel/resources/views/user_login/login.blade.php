@extends('login_register')

@section('content')


<div class="card-body p-4 login">
    <div class="head">
        
        <p class='msg'>Welcome back</p>
    </div>

    @if (session('message'))
    <div class="text-danger mb-2 text-center">{{ session('message') }}</div>
    @endif
    <form action="{{ route('user.login') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="userName" class="form-label">Username or Email</label>
            <?php
            $userName = "";
            if(null !== old('user_name')){
                $userName = old('user_name');
            }
            if(null !== old('email')){
                $userName = old('email');
            }
            if(null !== old('user_mobile_no')){
                $userName = old('user_mobile_no');
            }
            ?>
            <input name="userName" value="{{$userName}}" class="form-control" type="text" id="userName" placeholder="Enter your username or phone or email">
            @error('user_name')
            <span class=" text-small text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group input-group-merge">
                <input name="password" value="{{old('password')}}" type="password" id="password" class="form-control" placeholder="Enter your password">

                <div id="passEye" class="input-group-text" style="cursor: pointer;">
                    <span class="password-eye"></span>
                </div>

            </div>
            @error('password')
            <span class=" text-small text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                <label class="form-check-label" for="checkbox-signin">Remember me</label>
            </div>
        </div> --}}

        <div class="text-center d-grid">
            <button class="btn btn-primary" type="submit"> Log In </button>
        </div>

    </form>
</div> <!-- end card-body -->
@endsection