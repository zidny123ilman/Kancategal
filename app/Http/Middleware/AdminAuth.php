<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_logged_in')) {
            return redirect('/admin/login')->withErrors(['username' => 'Akses ditolak. Silakan login terlebih dahulu.']);
        }
        return $next($request);
    }
}
