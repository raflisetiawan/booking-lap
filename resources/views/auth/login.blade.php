@extends('layout')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-transparent text-center"> <img src="img/logo booking.png" width="150px" alt=""><br>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('authenticate') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input type="email" name="email" class="form-control" id="email" required
                                autofocus>

                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success">{{ __('Login') }}</button>
                        <p class="text-center">belum punya akun? <a href="{{route('daftar')}}" class="text-decoration-none">daftar</a></p>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
