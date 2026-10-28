<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse|JsonResponse
    {
        $available = function_exists('rj_frontend_locales') ? rj_frontend_locales() : ['en'];

        if (!in_array($locale, $available, true)) {
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'message' => __('Invalid language.')], 422);
            }
            return redirect()->back();
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'locale' => $locale]);
        }

        $redirect = $request->query('redirect');
        $referer = (is_string($redirect) && $redirect !== '' && str_starts_with($redirect, '/'))
            ? $redirect
            : ($request->headers->get('referer') ?: '/');

        $path = parse_url($referer, PHP_URL_PATH) ?: '/';
        $path = '/' . ltrim($path, '/');

        $utilityPrefixes = ['/admin', '/theme-assets', '/plugin-assets', '/rj-widget', '/rj-preview', '/rj-form', '/rj-fonts'];

        foreach ($utilityPrefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return redirect('/' . $locale);
            }
        }

        $segments = array_values(array_filter(
            explode('/', trim($path, '/')),
            fn ($s) => $s !== ''
        ));

        if (empty($segments)) {
            return redirect('/' . $locale);
        }

        if (preg_match('/^[a-z]{2}(_[A-Z]{2})?$/', $segments[0])) {
            $segments[0] = $locale;
        } else {
            array_unshift($segments, $locale);
        }

        return redirect('/' . implode('/', $segments));
    }
}
