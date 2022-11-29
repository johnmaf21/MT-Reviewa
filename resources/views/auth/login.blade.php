@extends('layouts.app')

@section('content')
    <div class="user__title">
        <h1>Login</h1>
    </div>
    <div class="welcome__text">
        <p>Login and get back to the movies and shows you love</p>
    </div>
    <div class="login-container">
        <form method="POST" action="{{ route('authenticate') }}">
            @csrf

            <div class="entry">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" email">
            </div>

            <div class="entry">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus placeholder=" password">
            </div>

            <div class="options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="forget-password">
                    <a href="/password/reset">Forgot Password</a>
                </div>
            </div>

            <div class="submit">
                <button type="submit" class="login-submit-button">
                    {{ __('Login') }}
                </button>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
            @error('password')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </form>
    </div>
    <div class="other-login-options">
        <p>Other Login Options</p>
        <a href="/auth/google/redirect"><img src="{{ asset('images/google.png') }}"></a>
        <a href="/auth/twitter/redirect"><img src="{{ asset('images/twitter.png') }}"></a>
        <a href="/auth/github/redirect"><img src="{{ asset('images/github.png') }}"></a>
    </div>
@endsection
