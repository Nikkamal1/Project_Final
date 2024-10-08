@extends('layouts.app')

@section('content')
<br></br>
<br></br>
<br></br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1 class="h3 mb-3 fw-normal">{{ __('ลงทะเบียน') }}</h1>

                <div class="form-floating mb-3">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Name">
                    <label for="name">{{ __('Name') }}</label>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                    <label for="email">{{ __('Email Address') }}</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                    <label for="password">{{ __('Password') }}</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit">
                    {{ __('Register') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
