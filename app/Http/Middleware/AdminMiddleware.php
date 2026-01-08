<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Menangani permintaan masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah user adalah admin (berdasarkan is_admin atau role)
        // Sesuaikan dengan kolom di database kamu (is_admin == 1)
        if (Auth::user()->is_admin == 1 || Auth::user()->role == 'admin') {
            return $next($request); // Berhasil, silakan masuk ke halaman admin
        }

        // 3. Jika bukan admin, tendang ke halaman depan user dengan pesan error
        return redirect('/')->with('error', 'Akses ditolak! Anda bukan administrator.');
    }
}