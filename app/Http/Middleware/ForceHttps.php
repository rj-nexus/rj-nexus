<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->secure()) {
            return $next($request);
        }

        if (app()->environment('local')) {
            return $next($request);
        }

        if (!file_exists(storage_path('installed.lock'))) {
            return $next($request);
        }

        $enabled = false;

        try {
            if (Schema::hasTable('rj_options')) {
                $enabled = rj_get_option('force_https') === '1';
            }
        } catch (\Throwable $e) {
            $enabled = false;
        }

        if (!$enabled) {
            return $next($request);
        }

        return redirect()->secure($request->getRequestUri(), 301);
    }
}
