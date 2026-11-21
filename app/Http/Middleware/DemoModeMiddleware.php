<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoModeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedPaths = [
            'login',
            'admin/login',
            'logout',
            'admin/logout',
        ];

        if ($request->is($allowedPaths)) {
            return $next($request);
        }

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Demo rejimində dəyişiklik etmək qadağandır!'
                ], 403);
            }

            return back()->with('error', 'Demo rejimində məlumatları silmək və ya dəyişmək mümkün deyil!');
        }

        return $next($request);
    }
}
