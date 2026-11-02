<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LangController extends Controller
{
    public function switch(string $locale)
    {
        if (preg_match('/^[a-z]{2}(_[A-Z]{2})?$/', $locale) && in_array($locale, rj_available_locales(), true)) {
            session(['admin_locale' => $locale]);
            app()->setLocale($locale);
        }

        return back();
    }
}
