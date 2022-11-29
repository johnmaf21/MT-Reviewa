@extends('layouts.app')

@section('content')
    <div class="user__title"><h1>Two Factor Authentication</h1></div>
    <div class="welcome__text"><p>Please enter the code sent to your email to login. If you haven't recieved the code press <a href="{{ route('login.resend') }}">here</a> for a new one</p></div>

    <div class="login-container">
        <form method="POST" action="{{ route('login.twoFactor') }}">
            @csrf

                <div class="entry">
                    <input id="two_factor_code" type="text" class="form-control @error('two_factor_code') is-invalid @enderror" name="two_factor_code" required autocomplete="two_factor_code" placeholder="  Enter code here">
                </div>

                <div class="submit">
                    <button type="submit" class="login-submit-button">
                        Verify
                    </button>
                </div>
                @error('two_factor_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
        </form>
    </div>
@endsection
