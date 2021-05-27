@extends('layouts.grace')

@section('content')
<div class="row d-flex align-items-center justify-content-center vh-500">
    <div class="col-lg-6 pl-lg-5">
        <div class="osahan-signin shadow-sm bg-white p-4 rounded">
            <div class="p-3">
                <h2 class="my-0">Welcome Back</h2>
                <p class="small mb-4">Sign in to Continue.</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input placeholder="Enter Email" type="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{ old('email') }}" autocomplete="email" autofocus required name="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input placeholder="Enter Password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" autocomplete="current-password" required name="password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-success btn-lg rounded btn-block">
                            Sign In
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                </form>
                <p class="text-center mt-3 mb-0"><a href="{{route('register')}}" class="text-dark">Don't have an account? Sign up</a></p>
            </div>
        </div>
    </div>
</div>

@endsection