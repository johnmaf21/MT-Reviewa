@extends('layouts.app')

@section('content')
    <div class="user__title"><h1>Reset Password</h1></div>
    <div class="welcome__text">
        <p>Enter the email and you're new password</p>
    </div>

    <div class="login-container">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="entry">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" email">
            </div>

            <div class="entry">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" autofocus placeholder=" password">
            </div>

            <div class="entry">
                <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" autofocus placeholder=" confirm password">
            </div>

            <div class="submit">
                <button type="submit" class="login-submit-button">
                    Reset Password
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
@endsection
