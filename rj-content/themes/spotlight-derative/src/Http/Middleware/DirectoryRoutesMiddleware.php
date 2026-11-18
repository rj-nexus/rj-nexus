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

        if (preg_match('/^([a-zA-Z]{2}(?:_[A-Z]{2})?)\/(plugins|themes|docs)(?:\/([^\/]+))?$/', $path, $matches)) {
            $locale = $matches[1];
            $type = $matches[2];
            $slug = $matches[3] ?? null;

            app()->setLocale($locale);
            session(['locale' => $locale]);

            $controller = app(DirectoryController::class);

            if ($type === 'plugins') {
                $result = $slug ? $controller->pluginDetails($request, $locale, $slug) : $controller->plugins($request);
            } elseif ($type === 'themes') {
                $result = $slug ? $controller->themeDetails($request, $locale, $slug) : $controller->themes($request);
            } else {
                $result = $controller->docs($request, $locale, $slug);
            }

            return response($result);
        }

        return $next($request);
    }
}