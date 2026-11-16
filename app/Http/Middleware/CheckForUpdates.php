<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckForUpdates
{
    public function handle(Request $request, Closure $next): Response
    {
        $lastChecked = Cache::get('rj_update_check_time', 0);
        
        // 900 saniyə = 15 dəqiqə
        if (time() - $lastChecked > 900) { 
            Cache::put('rj_update_check_time', time(), now()->addDay());

            dispatch(function () {
                \Illuminate\Support\Facades\Artisan::call('rj:check-updates');
            })->afterResponse();
        }

        return $next($request);
    }
}