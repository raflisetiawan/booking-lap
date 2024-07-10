<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request){


        $credentials = $request->only('email', 'password');

    if (!User::where('email', $credentials['email'])->exists()) {
        return redirect()->back()->withErrors([
            'email' => 'Email belum terdaftar',
        ]);
    }

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/dashboard');
    } else {
        return redirect()->back()->withErrors([
            'password' => 'password salah',
        ]);
    }

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
