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

        $isWriteMethod = in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']);
        $isDangerousGet = $request->isMethod('GET') && preg_match('/(delete|destroy|remove|trash|force-delete|bulk|install|uninstall|activate|deactivate|upload|store|update)/i', $request->path());

        if ($isWriteMethod || $isDangerousGet) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Demo rejimində dəyişiklik etmək və ya fayl silmək qadağandır!'
                ], 403);
            }

            return back()->with('error', 'Demo rejimində dəyişiklik etmək və ya silmək mümkün deyil!');
        }

        return $next($request);
    }
}
