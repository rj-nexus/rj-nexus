<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAdmin = $request->is('admin') || $request->is('admin/*');

        $available = $isAdmin ? rj_available_locales() : rj_frontend_locales();
        $default = config('app.locale');

        if ($isAdmin) {
            $sessionLocale = session('admin_locale');
            $locale = ($sessionLocale && in_array($sessionLocale, $available, true))
                ? $sessionLocale
                : $default;

            app()->setLocale($locale);

            return $next($request);
        }

        $routeLocale = $request->route('locale');

        if (is_string($routeLocale) && $routeLocale !== '') {
            if (!in_array($routeLocale, $available, true)) {
                $path = $request->path();
                $newPath = preg_replace('/^' . preg_quote($routeLocale, '/') . '\b/', $default, $path);

                if ($newPath === $path) {
                    $newPath = $default;
                }

                return redirect()->to('/' . ltrim($newPath, '/'));
            }

            $locale = $routeLocale;
            session(['locale' => $locale]);
        } else {
            $sessionLocale = session('locale');
            $locale = ($sessionLocale && in_array($sessionLocale, $available, true))
                ? $sessionLocale
                : $default;

            if (!$sessionLocale && rj_get_option('auto_detect_language')) {
                $preferred = $request->getPreferredLanguage($available);
                if ($preferred && in_array($preferred, $available, true)) {
                    $locale = $preferred;
                    session(['locale' => $preferred]);
                }
            }
        }

        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
