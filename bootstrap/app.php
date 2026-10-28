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
        $routeLocale = $request->route('locale');
        $available = rj_frontend_locales();
        $default = config('app.locale');

        if (is_string($routeLocale) && $routeLocale !== '') {
            if (!in_array($routeLocale, $available, true)) {
                abort(404);
            }

            $locale = $routeLocale;
            session(['locale' => $locale]);
        } else {
            $sessionLocale = session('locale');
            $locale = ($sessionLocale && $this->isValidLocale($sessionLocale))
                ? $sessionLocale
                : $default;
        }

        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }

    protected function isValidLocale(string $locale): bool
    {
        return (bool) preg_match('/^[a-z]{2}(_[A-Z]{2})?$/', $locale);
    }
}
