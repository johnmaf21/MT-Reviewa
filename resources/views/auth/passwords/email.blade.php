@extends('layouts.app')

@section('content')
<div class="card">
    <div class="user__title"><h1>Request New Password</h1></div>
    <div class="welcome__text">
        <p>Enter the email for the password you want to reset</p>
    </div>

    <div class="login-container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="entry">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" email">
            </div>

            <div class="submit">
                    <button type="submit" class="reset-button">
                        {{ __('Send Password Reset Link') }}
                    </button>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </form>
    </div>
</div>
@endsection
