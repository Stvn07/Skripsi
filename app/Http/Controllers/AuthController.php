<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
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
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ]
        ]);

        $haveAccount = User::where('user_email', $request->input('user_email'))->exists();
        if (!$haveAccount) {
            return redirect()->route('login')->with('error', 'Akun Belum Terdaftar. Silakan Sign Up terlebih dahulu.');
        }

        $credentials = $request->only('user_email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        } else {
            return redirect()->route('login')->with('error', 'Akun tidak ditemukan. Silakan coba lagi.');
        }
    }

    function register()
    {
        return view('registerPage');
    }

    function registerPost(Request $request)
    {
        $messages = [
            'user_email.unique' => 'Email pengguna sudah terdaftar, silakan lakukan sign up.'
        ];

        $request->validate([
            'user_full_name' => 'required|string|min:3|max:25',
            'user_email' => 'required|email|unique:users,user_email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
            'user_address' => 'required|string|min:10|max:100',
            'user_phone_number' => 'required|string|min:12|max:12',
        ], $messages);

        $data = $request->only('user_full_name', 'user_email', 'password', 'user_address', 'user_phone_number');
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if (!$user) {
            return redirect()->route('register')->with('error', 'Registration failed. Please try again.');
        } else {
            \Log::info('User created successfully: ' . $user->id);
        }
        Auth::login($user);

        return redirect()->route('home');
    }

    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

}
