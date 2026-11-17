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
        if (Cache::add('rj_updates_check_lock', true, now()->addMinutes(15))) {
            dispatch(function () {
                \Illuminate\Support\Facades\Artisan::call('rj:check-updates');
            })->afterResponse();
        }

        return $next($request);
    }
}