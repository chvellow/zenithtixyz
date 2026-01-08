<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // cek admin
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => 1
        ])) {
            return redirect()->route('admin.dashboard'); // langsung ke dashboard
        }

        return back()->withErrors(['email' => 'Email/password tidak valid atau bukan admin.']);
    }
}
