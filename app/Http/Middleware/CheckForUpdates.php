<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckForUpdates
{
    public function handle(Request $request, Closure $next): Response
    {
        if ((string) rj_get_option('auto_check', '1') !== '1') {
            return $next($request);
        }

        if (!Cache::add('rj_updates_check_lock', true, now()->addMinutes(15))) {
            return $next($request);
        }

        dispatch(function () {
            try {
                \Illuminate\Support\Facades\Artisan::call('rj:check-updates');
            } catch (\Throwable $e) {
                Cache::forget('rj_updates_check_lock');
                Log::warning('rj:check-updates failed: ' . $e->getMessage());
            }
        })->afterResponse();

        return $next($request);
    }
}