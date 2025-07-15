<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string|null $guard = null)
    {
        if (Auth::check()) {
            // Redirect berdasarkan role user
            if (Auth::user()->role === 'admin') {
                return redirect('/dashboard');
            } elseif (Auth::user()->role === 'kader') {
                return redirect('/dashboard1');
            } else {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
