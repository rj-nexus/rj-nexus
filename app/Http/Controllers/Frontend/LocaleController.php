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
        $available = function_exists('rj_available_locales') ? rj_available_locales() : ['en'];
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
        if (is_string($redirect) && $redirect !== '' && str_starts_with($redirect, '/')) {
            return redirect($redirect);
        }

        return redirect()->back();
    }
}
