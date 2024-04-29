<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    function login()
    {
        return view('loginPage');
    }

    function loginPost(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email',
            'password' => 'required|alpha_num',
        ]);

        $credentials = $request->only('user_email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        }

        return redirect(route('login'))->with("error", "Please Input Data Correctly");
    }

    function register()
    {
        return view('registerPage');
    }

    function registerPost(Request $request)
    {
        $request->validate([
            'user_full_name' => 'required',
            'user_email' => 'required|email|unique:users',
            'password' => 'required|alpha_num',
            'user_address' => 'required',
            'user_phone_number' => 'required'
        ]);

        $data['user_full_name'] = $request->user_full_name;
        $data['user_email'] = $request->user_email;
        $data['password'] = Hash::make($request->password);
        $data['user_address'] = $request->user_address;
        $data['user_phone_number'] = $request->user_phone_number;
        $user = User::create($data);
        if (!$user) {
            return redirect(route('register'))->with("error", "Please Input Data Correctly");
        }
        return redirect(route('home'))->with("success", "Register Process Success");
    }

    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

}
