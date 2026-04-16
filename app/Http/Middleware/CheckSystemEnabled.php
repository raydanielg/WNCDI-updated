<?php

namespace App\Http\Middleware;

use App\Models\SecuritySetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSystemEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow superadmin session to bypass system lock
        if ($request->session()->get('is_superadmin') === true) {
            return $next($request);
        }

        // Skip certain routes (auth, system-off, superadmin panel)
        if ($request->routeIs('login', 'logout', 'password.*', 'system.off', 'superadmin.panel', 'superadmin.system.toggle')) {
            return $next($request);
        }

        $setting = SecuritySetting::query()->first();

        if ($setting && $setting->system_enabled === false) {
            return redirect()->route('system.off');
        }

        return $next($request);
    }
}
