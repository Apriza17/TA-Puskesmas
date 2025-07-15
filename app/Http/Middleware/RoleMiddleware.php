<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/Login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah role pengguna sesuai
        if (Auth::user()->role !== $role) {
            return redirect('/Error')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
