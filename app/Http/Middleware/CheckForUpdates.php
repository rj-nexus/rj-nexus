<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForUpdates
{
    public function handle(Request $request, Closure $next): Response
    {
        // TEST REJİMİ: Hər səhifə yenilənməsində yoxlayır (Keş yoxdur)
        dispatch(function () {
            \Illuminate\Support\Facades\Artisan::call('rj:check-updates');
        })->afterResponse();

        return $next($request);
    }
}