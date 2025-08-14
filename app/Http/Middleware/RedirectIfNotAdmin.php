<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        // Pastikan user sudah login dan role-nya adalah 'admin'
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
