<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

       if (Auth::attempt($credentials)) {
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->role === 'candidate') {
        return redirect('/candidate/dashboard');
    }

    if ($user->role === 'employer') {
        return redirect('/employer/dashboard');
    }

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    Auth::logout();

    return redirect('/login')->withErrors([
        'email' => 'Geçersiz kullanıcı rolü.',
    ]);
}

        return back()->withErrors([
            'email' => 'E-posta veya şifre hatalı.',
        ])->onlyInput('email');
    }
}
