<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

class RegisterController extends Controller
{

    public function register(){
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        if(!Auth::guest()){
            if(Auth::user()->two_factor_code !== null){
                Auth::logout();
            }
        }
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'dob' => 'required',
            'profile_pic' => 'required'
        ]);

        $emailUser = User::where('email', $request->email)->where('auth_type', null)->first();
        $usernameUser = User::where('username', $request->username)->where('auth_type', null)->first();

        //if a user with the same email already exists return an error
        if ($emailUser !== null) {
            return back()->withErrors([
                                    'email' => 'This email already exists.',
                                ]);
        }

        //if a user with the same username already exists return an error
        if ($usernameUser !== null) {
            return back()->withErrors([
                    'username' => 'This username already exists.',
                ]);
        }

       $user = $this->createNewUser($request);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials,false)){
            $request->session()->regenerate();
            return redirect()->intended();
        }

        return redirect()->intended();
    }

    public function createNewUser(Request $request){
        $imageName = time().'.'.$request->profile_pic->extension();
        $path = $request->profile_pic->move(public_path("images/profile_pictures"), $imageName);

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->dob = $request->dob;
        $user->profile_pic = $path;
        $user->is_private = false;
        $user->save();

        return $user;

    }

}
