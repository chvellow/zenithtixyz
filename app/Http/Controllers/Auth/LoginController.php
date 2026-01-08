<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Default redirect jika fungsi authenticated tidak terpanggil
    protected $redirectTo = '/';

    /**
     * Logic setelah user berhasil login
     */
   protected function authenticated(Request $request, $user)
{
    // Jika dia admin, kirim ke dashboard admin
    if ($user->is_admin == 1 || $user->role == 'admin') { 
        return redirect()->route('admin.dashboard'); 
    }

    // Jika user biasa, kirim ke halaman depan bioskop (Movies)
    return redirect('/'); 
}

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}