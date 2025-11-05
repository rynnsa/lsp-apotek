<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            return back();
        }
        return view('be.login', ['title' => 'Login Dashmin']);

       
    }
    function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infologin)) {
            return redirect('landing')->with('success', 'Login Berhasil');
        } else {
            return redirect()->back()->withErrors(['error' => 'akun atau password salah'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login-dashmin')->with('success', 'Logout Berhasil');
    }
} 