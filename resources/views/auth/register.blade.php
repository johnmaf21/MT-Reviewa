@extends('layouts.app')

@section('content')
    <div class="user__title">
        <h1>Register</h1>
    </div>
    <div class="welcome__text">
        <p>Sign up and keep up-to-date with all your favorite shows</p>
    </div>
    <form enctype="multipart/form-data" action="{{ route('registerUser') }}" method="POST">
        @csrf
        <div class="flex-container">
            <div class="register_one">
                <div class="entry">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                    @enderror
                </div>

                <div class="entry">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus placeholder=" password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                    @enderror
                </div>

                <div class="entry">
                    <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" required autocomplete="dob" autofocus placeholder=" DD/MM/YYYY">

                    @error('dob')
                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                    @enderror
                </div>
            </div>

            <div class="register__two">
                <div class="entry">
                    <input id="profile_pic" type="file" class="form-control @error('profile_pic') is-invalid @enderror" name="profile_pic" value="{{ old('profile_pic') }}" required autocomplete="profile_pic" autofocus>

                    @error('profile_pic')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="entry">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder=" username">

                    @error('username')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="submit">
            <button type="submit" class="submit-button">
                Register
            </button>
        </div>
    </form>
@endsection
