<?php

namespace Spotlight\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spotlight\Http\Controllers\DirectoryController;

class DirectoryRoutesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // URL-in strukturunu yoxlayırıq: /en/plugins və ya /en/plugins/rj-commerce
        $path = $request->path();
        
        // Regex: {dil_kodu}/{plugins|themes}/{slug?}
        if (preg_match('/^([a-zA-Z]{2}(?:_[A-Z]{2})?)\/(plugins|themes)(?:\/([^\/]+))?$/', $path, $matches)) {
            $locale = $matches[1];
            $type = $matches[2]; // plugins və ya themes
            $slug = $matches[3] ?? null;

            // Dili təyin edirik ki, tərcümələr düzgün işləsin
            app()->setLocale($locale);
            session(['locale' => $locale]);

            $controller = app(DirectoryController::class);
            
            if ($type === 'plugins') {
                return $slug ? $controller->pluginDetails($request, $locale, $slug) : $controller->plugins($request);
            } else {
                return $slug ? $controller->themeDetails($request, $locale, $slug) : $controller->themes($request);
            }
        }

        return $next($request);
    }
}