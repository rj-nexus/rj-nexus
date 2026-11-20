<?php

namespace App\Support\ResponseCache;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;

class RjCacheProfile extends CacheAllSuccessfulGetRequests
{
    public function shouldCacheRequest(Request $request): bool
    {
        if (!parent::shouldCacheRequest($request)) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson() || $request->pjax()) {
            return false;
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return false;
        }

        if ($request->is('install.php') || $request->is('installer') || $request->is('installer/*')) {
            return false;
        }

        if (Auth::check()) {
            return false;
        }

        if (session()->has('errors') || session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('status')) {
            return false;
        }

        if ($request->has('preview') || $request->has('rj_theme_preview') || $request->has('token')) {
            return false;
        }

        if (app()->isDownForMaintenance()) {
            return false;
        }

        if (session()->has('rj_theme_preview_token') || session()->has('rj_theme_preview_slug')) {
            return false;
        }

        return true;
    }

    public function shouldCacheResponse(\Symfony\Component\HttpFoundation\Response $response): bool
    {
        if (!parent::shouldCacheResponse($response)) {
            return false;
        }

        if ($response->headers->has('Set-Cookie')) {
            return false;
        }

        $cacheControl = (string) $response->headers->get('Cache-Control', '');
        if (stripos($cacheControl, 'no-cache') !== false || stripos($cacheControl, 'no-store') !== false || stripos($cacheControl, 'private') !== false) {
            return false;
        }

        return true;
    }

    public function useCacheNameSuffix(Request $request): string
    {
        $parts = [];

        $parts[] = 'locale=' . app()->getLocale();
        $parts[] = 'theme=' . (string) rj_get_option('frontend_theme', 'rj-default');

        return implode('|', $parts);
    }
}