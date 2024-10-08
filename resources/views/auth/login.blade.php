@extends('layouts.app')

@section('content')
<br></br>
<br></br>
<br></br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 p-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="h3 mb-3 fw-normal">{{ __('เข้าสู่ระบบ') }}</h1>

                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                    <label for="email">{{ __('Email address') }}</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    <label for="password">{{ __('Password') }}</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit">
                    {{ __('Sign in') }}
                </button>

            </form>
        </div>
    </div>
</div>
@endsection
