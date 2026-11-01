<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));

        $langPath = lang_path($locale);

        if (File::isDirectory($langPath) || $locale === config('app.locale')) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
