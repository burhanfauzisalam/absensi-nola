<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login dan bukan di halaman login, redirect ke login
        if (!Auth::check() && !$request->is('login', 'login-post')) {
            return redirect('/login');
        }

        // Jika user sudah login dan mencoba mengakses halaman login, redirect ke absensi
        if (Auth::check() && $request->is('login', 'login-post')) {
            return redirect('/absensi');
        }

        return $next($request);
    }
}
