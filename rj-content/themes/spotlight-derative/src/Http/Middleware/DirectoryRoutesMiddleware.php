<?php

namespace Spotlight\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spotlight\Http\Controllers\DirectoryController;

class DirectoryRoutesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        
        // URL-in strukturunu yoxlayırıq: /en/plugins və ya /en/plugins/rj-commerce
        if (preg_match('/^([a-zA-Z]{2}(?:_[A-Z]{2})?)\/(plugins|themes)(?:\/([^\/]+))?$/', $path, $matches)) {
            $locale = $matches[1];
            $type = $matches[2]; // plugins və ya themes
            $slug = $matches[3] ?? null;

            app()->setLocale($locale);
            session(['locale' => $locale]);

            $controller = app(DirectoryController::class);
            
            if ($type === 'plugins') {
                $result = $slug ? $controller->pluginDetails($request, $locale, $slug) : $controller->plugins($request);
            } else {
                $result = $slug ? $controller->themeDetails($request, $locale, $slug) : $controller->themes($request);
            }

            // VACİB: View obyektini Response-a çeviririk ki, digər middleware-lər xəta verməsin
            return response($result);
        }

        return $next($request);
    }
}