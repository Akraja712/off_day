@extends('layouts.auth')

@section('css')
<style>
    .invalid-feedback {
        display: block
    }
</style>
@endsection

@section('content')
<p class="login-box-msg">Log in to start your session</p>
<form action="{{ route('login') }}" method="post">
    @csrf
    <div class="form-group">
        <div class="input-group">
            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
                placeholder="Mobile Number" value="{{ old('mobile') }}" required autocomplete="mobile">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-mobile-alt"></span>
                </div>
            </div>
        </div>
        @error('mobile')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <div class="input-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                name="password" required autocomplete="current-password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                    Remember Me
                </label>
            </div>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-success btn-block">Log In</button>
        </div>
    </div>
</form>
<p class="mb-1">
    <a href="{{ route('password.request') }}">I forgot my password</a>
</p>

<!--<p class="mb-0">
    <a href="{{ route('register')}}" class="text-center">Register</a>
</p>-->
@endsection
