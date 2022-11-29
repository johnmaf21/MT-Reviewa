<?php

namespace App\Http\Controllers;

use App\Models\TwoFactorCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login(Request $request)
        {
            if(!session()->has('url.intended'))
            {
                session(['url.intended' => url()->previous()]);
            }
            return view('auth/login');
        }

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials,$request->rememberMe)) {

            Auth::user()->generateTwoFactorCode();
            Auth::user()->notify(new TwoFactorCode());

            return view('auth/two-factor-challenge',['test'=>'test']);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request) {
      Auth::logout();
      return redirect('/');
    }

    public function showTwoFactor(Request $request){
        return view('auth/two-factor-challenge');
    }

    public function twoFactor(Request $request){
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        if($request->input('two_factor_code') == Auth::user()->two_factor_code)
        {
            Auth::user()->resetTwoFactorCode();
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code you have entered does not match']);
    }


    public function resend()
    {
        Auth::user()->generateTwoFactorCode();
        Auth::user()->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
    }

    public function githubLogin(Request $request){
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('github_id', $githubUser->id)->first();

        if (!$user) {
            $user = User::create([
                'username' => $githubUser->name,
                'email' => $githubUser->email,
                'github_id' => $githubUser->id,
                'password' => Hash::make('password'),
                'profile_pic' => $githubUser->getAvatar(),
                'is_private' => false,
                'auth_type' => 'github',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended();
    }

    public function googleLogin(Request $request){
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = User::create([
                'username' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make('password'),
                'profile_pic' => $googleUser->getAvatar(),
                'is_private' => false,
                'auth_type' => 'google',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended();
    }

    public function linkedInLogin(Request $request){
        $linkedInUser = Socialite::driver('linkedin')->user();

        $user = User::where('google_id', $linkedInUser->id)->first();

        if (!$user) {
            $user = User::create([
                'username' => $linkedInUser->name,
                'email' => $linkedInUser->email,
                'google_id' => $linkedInUser->id,
                'password' => Hash::make('password'),
                'profile_pic' => $linkedInUser->getAvatar(),
                'is_private' => false,
                'auth_type' => 'linkedIn',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended();
    }

    public function twitterLogin(Request $request){
        $twitterUser = Socialite::driver('twitter')->user();

        $user = User::where('twitter_id', $twitterUser->id)->first();

        if (!$user) {
            $user = User::create([
                'username' => $twitterUser->name,
                'email' => $twitterUser->email,
                'google_id' => $twitterUser->id,
                'password' => Hash::make('password'),
                'profile_pic' => $twitterUser->getAvatar(),
                'is_private' => false,
                'auth_type' => 'twitter',
            ]);
        }

        Auth::login($user);

        $request->session()->regenerate();
        return redirect()->intended();
    }
}
