<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class DocsController extends Controller
{
    public function index(string $locale, ?string $slug = null)
    {
        $view = $slug ? 'theme::docs.' . $slug : 'theme::docs.index';

        if (view()->exists($view)) {
            return view($view, compact('locale', 'slug'));
        }

        abort(404);
    }
}