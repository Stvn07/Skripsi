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
            'password' => 'required|alpha_num|min:8|max:20',
            // 'password' => [
            //     'required',
            //     'string',
            //     'min:8',              // Minimal 8 karakter
            //     'max:20',             // Maksimal 20 karakter
            //     'regex:/[a-z]/',      // Setidaknya satu huruf kecil
            //     'regex:/[A-Z]/',      // Setidaknya satu huruf besar
            //     'regex:/[0-9]/',      // Setidaknya satu angka
            //     'regex:/[@$!%*?&#]/', // Setidaknya satu karakter khusus
            // ]
        ]);

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
        $request->validate([
            'user_full_name' => 'required|string|min:3|max:25',
            'user_email' => 'required|email|unique:users',
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
            'user_phone_number' => 'required|min:12'
        ]);

        $data['user_full_name'] = $request->user_full_name;
        $data['user_email'] = $request->user_email;
        $data['password'] = Hash::make($request->password);
        $data['user_address'] = $request->user_address;
        $data['user_phone_number'] = $request->user_phone_number;
        $user = User::create($data);
        if (!$user) {
            return redirect(route('register'));
        }
        Auth::login($user);
        return redirect(route('home'));
    }

    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

}
