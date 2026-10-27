<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class LogoWidget extends BaseWidget
{
    public function id(): string
    {
        return 'logo';
    }

    public function name(): string
    {
        return __('Logo');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'header';
    }

    public function description(): string
    {
        return __('Display your site logo with a custom link and size.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'image',
                'type'    => 'media',
                'label'   => __('Logo Image'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'url',
                'type'    => 'text',
                'label'   => __('Link URL'),
                'default' => '/',
                'tab'     => 'content',
            ],
            [
                'name'    => 'new_tab',
                'type'    => 'toggle',
                'label'   => __('Open Link in New Tab'),
                'default' => false,
                'tab'     => 'content',
            ],
            [
                'name'    => 'alt',
                'type'    => 'text',
                'label'   => __('Alt Text (SEO)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Leave empty to use the site name.'),
            ],
            [
                'name'    => 'width',
                'type'    => 'range',
                'label'   => __('Width (px)'),
                'default' => 140,
                'min'     => 20,
                'max'     => 400,
                'step'    => 5,
                'tab'     => 'style',
            ],
            [
                'name'    => 'max_height',
                'type'    => 'range',
                'label'   => __('Max Height (px)'),
                'default' => 80,
                'min'     => 20,
                'max'     => 240,
                'step'    => 5,
                'tab'     => 'style',
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'left',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                    'right'  => __('Right'),
                ],
            ],
            [
                'name'    => 'color_filter',
                'type'    => 'select',
                'label'   => __('Logo Color'),
                'default' => 'none',
                'tab'     => 'style',
                'help'    => __('Use "Force white" for light logos on dark headers (or the opposite).'),
                'options' => [
                    'none'  => __('Original'),
                    'white' => __('Force white'),
                    'black' => __('Force black'),
                ],
            ],
            [
                'name'    => 'hover_opacity',
                'type'    => 'toggle',
                'label'   => __('Fade on Hover'),
                'default' => true,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $src = $this->imageUrl($settings['image'] ?? '');

        $alt = mb_substr(trim((string) ($settings['alt'] ?? '')), 0, 160);
        if ($alt === '') {
            $site = function_exists('rj_get_option') ? trim((string) rj_get_option('site_name', '')) : '';
            $alt = $site !== '' ? $site : 'Logo';
        }

        $align = $this->pick($settings['align'] ?? 'left', ['left', 'center', 'right'], 'left');

        $opts = [
            'src'      => $src,
            'url'      => $this->safeUrl((string) ($settings['url'] ?? '/')),
            'blank'    => $this->flag($settings['new_tab'] ?? null, false),
            'alt'      => $alt,
            'width'    => max(20, min(400, (int) ($settings['width'] ?? 140))),
            'max_h'    => max(20, min(240, (int) ($settings['max_height'] ?? 80))),
            'justify'  => ['left' => 'flex-start', 'center' => 'center', 'right' => 'flex-end'][$align],
            'objpos'   => $align,
            'filter'   => $this->pick($settings['color_filter'] ?? 'none', ['none', 'white', 'black'], 'none'),
            'hover'    => $this->flag($settings['hover_opacity'] ?? null, true),
        ];

        $uid = 'logo_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.logo', [
            'o'   => $opts,
            'uid' => $uid,
        ])->render();
    }

    /**
     * Normalizes whatever the media field stored (string, array, object) into a URL the
     * current page can actually load.
     */
    private function imageUrl(mixed $value): string
    {
        if (is_object($value)) {
            $value = (array) $value;
        }

        if (is_array($value)) {
            $found = '';

            foreach (['url', 'src', 'path', 'file', 'original', 'full'] as $key) {
                if (!empty($value[$key]) && is_string($value[$key])) {
                    $found = $value[$key];
                    break;
                }
            }

            $value = $found;
        }

        if (!is_string($value)) {
            return '';
        }

        $value = trim($value);

        if ($value === '') {
            return '';
        }

        if (str_starts_with($value, '//')) {
            $value = 'https:' . $value;
        }

        if (preg_match('#^data:image/(png|jpe?g|gif|webp|avif|svg\+xml)[;,]#i', $value)) {
            return $value;
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $value)) {
            if (!preg_match('/^https?:/i', $value)) {
                return '';
            }

            $parts = parse_url($value);
            $host = strtolower((string) ($parts['host'] ?? ''));
            $reqHost = strtolower(request()->getHost());
            $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));

            $local = in_array($host, ['localhost', '127.0.0.1', '::1', '[::1]'], true)
                || ($appHost !== '' && $host === $appHost);

            // Same site saved under another host (e.g. http://localhost vs 127.0.0.1:8000): use a root-relative path
            if ($host !== '' && $host !== $reqHost && $local) {
                return ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');
            }

            return $value;
        }

        if (str_starts_with($value, '/')) {
            return $value;
        }

        return url('/' . ltrim($value, '/'));
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '/';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '/';
        }

        return $url;
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function flag(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }
}
