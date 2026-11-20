<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\Middlewares\CacheResponse;

class SmartResponseCache
{
    public function handle(Request $request, Closure $next): Response
    {
        // Əgər admin paneldən keş söndürülübsə, keşləmədən keç
        if (rj_get_option('response_cache_enabled', '0') !== '1') {
            return $next($request);
        }

        // Əgər aktivdirsə, Spatie-nin öz middleware-ini işə sal
        return app(CacheResponse::class)->handle($request, $next);
    }
}