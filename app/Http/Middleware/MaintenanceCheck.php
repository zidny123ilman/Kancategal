<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class MaintenanceCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Set locale based on database setting
        \Illuminate\Support\Facades\App::setLocale(Setting::get('default_language', 'id'));

        // Check if maintenance mode is enabled in the database
        if (Setting::get('maintenance_mode') === '1') {
            // Bypass maintenance mode for admin dashboard, admin assets, or active admin sessions
            if ($request->is('admin*') || $request->is('admin/*') || session()->has('admin_logged_in')) {
                return $next($request);
            }

            // Return custom maintenance page view with 503 HTTP status
            return response()->view('pages.maintenance', [], 503);
        }

        return $next($request);
    }
}
