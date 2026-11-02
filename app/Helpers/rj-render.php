<?php

use App\DynamicTags\TagRegistry;
use App\Widgets\WidgetRegistry;

if (!function_exists('rj_localize_builder_settings')) {
    function rj_localize_builder_settings(array $settings, string $locale, string $baseLocale): array
    {
        $localized = [];

        foreach ($settings as $key => $value) {
            if (is_string($key) && preg_match('/^(.+)__([a-z]{2})$/', $key, $matches)) {
                continue;
            }

            $localKey = $key . '__' . $locale;

            if ($locale !== $baseLocale && isset($settings[$localKey])) {
                $localized[$key] = $settings[$localKey];
            } else {
                if (is_array($value)) {
                    $localized[$key] = rj_localize_builder_settings($value, $locale, $baseLocale);
                } else {
                    $localized[$key] = $value;
                }
            }
        }

        return $localized;
    }
}

if (!function_exists('rj_resolve_dynamic')) {
    function rj_resolve_dynamic($value)
    {
        if (!is_array($value)) {
            return $value;
        }

        if (($value['source'] ?? '') !== 'dynamic') {
            return $value;
        }

        $tag = $value['tag'] ?? '';

        if ($tag === '') {
            return '';
        }

        $options = $value['options'] ?? [];

        if (!is_array($options)) {
            $options = [];
        }

        return TagRegistry::resolve($tag, $options);
    }
}

if (!function_exists('rj_resolve_dynamics')) {
    function rj_resolve_dynamics(array $settings): array
    {
        foreach ($settings as $key => $value) {
            if (is_array($value) && ($value['source'] ?? '') === 'dynamic') {
                $settings[$key] = rj_resolve_dynamic($value);
            }
        }

        return $settings;
    }
}

if (!function_exists('rj_render_block')) {
    function rj_render_block(array $block): string
    {
        $type = $block['type'] ?? '';

        if ($type === '') {
            return '';
        }

        $widget = WidgetRegistry::get($type);

        if (!$widget) {
            return '';
        }

        $settings = $block['settings'] ?? [];

        $locale = app()->getLocale();
        $baseLocale = config('app.base_locale', config('app.locale'));

        // ==========================================
        // TEST KODU BAŞLANGICI
        // ==========================================
        if ($type === 'heading' || $type === 'text') {
            dd([
                'Widget' => $type,
                'Laravel Cari Dil (Locale)' => $locale,
                'Laravel Baza Dil (Base)' => $baseLocale,
                'Bazadakı İngilis mətni (text)' => $settings['text'] ?? 'YOXDUR',
                'Bazadakı Azərbaycan mətni (text__az)' => $settings['text__az'] ?? 'YOXDUR',
            ]);
        }
        // ==========================================
        // TEST KODU SONU
        // ==========================================

        $settings = rj_localize_builder_settings($settings, $locale, $baseLocale);

        $settings = rj_resolve_dynamics($settings);

        $children = $block['children'] ?? [];

        if (in_array($type, ['container', 'structure-container', 'layout-container'], true)) {
            return $widget->render($settings, $children);
        }

        return $widget->render($settings);
    }
}
