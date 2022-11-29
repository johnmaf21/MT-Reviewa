@extends('layouts.app')

@section('content')
    <div class="user__title"><h1>{{ __('Verify Your Email Address') }}</h1></div>
    <div class="welcome__text">
        <p>{{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}</p>
    </div>
    <div class="login-container">
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="reset-button">{{ __('click here to request another') }}</button>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
        </form>
    </div>
@endsection
