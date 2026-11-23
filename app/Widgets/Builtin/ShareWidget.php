<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ShareWidget extends BaseWidget
{
    public function id(): string
    {
        return 'share';
    }

    public function name(): string
    {
        return __('Share');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Glass-style share buttons with automatic page sharing and copy link.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Share'), 'tab' => 'content'],
            ['name' => 'show_title', 'type' => 'toggle', 'label' => __('Show Title'), 'default' => true, 'tab' => 'content'],
            [
                'name' => 'share_url',
                'type' => 'text',
                'label' => __('Share URL'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => 'https://example.com/page',
                'help' => __('Leave empty to share the current page automatically.'),
            ],
            [
                'name' => 'share_text',
                'type' => 'text',
                'label' => __('Share Text'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Leave empty to use the page title.'),
            ],

            ['name' => 'net_whatsapp', 'type' => 'toggle', 'label' => __('WhatsApp'), 'default' => true, 'tab' => 'content'],
            ['name' => 'net_telegram', 'type' => 'toggle', 'label' => __('Telegram'), 'default' => true, 'tab' => 'content'],
            ['name' => 'net_facebook', 'type' => 'toggle', 'label' => __('Facebook'), 'default' => true, 'tab' => 'content'],
            ['name' => 'net_x', 'type' => 'toggle', 'label' => __('X (Twitter)'), 'default' => true, 'tab' => 'content'],
            ['name' => 'net_linkedin', 'type' => 'toggle', 'label' => __('LinkedIn'), 'default' => true, 'tab' => 'content'],
            ['name' => 'net_email', 'type' => 'toggle', 'label' => __('Email'), 'default' => false, 'tab' => 'content'],
            ['name' => 'net_copy', 'type' => 'toggle', 'label' => __('Copy Link'), 'default' => true, 'tab' => 'content'],
            ['name' => 'net_native', 'type' => 'toggle', 'label' => __('Native Share (mobile)'), 'default' => true, 'tab' => 'content', 'help' => __('Opens the device share sheet. Hidden automatically if not supported.')],

            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'glass',
                'tab' => 'style',
                'options' => [
                    'glass' => __('Glass (Light)'),
                    'glass-dark' => __('Glass (Dark)'),
                    'outline' => __('Outline'),
                ],
            ],
            ['name' => 'show_backdrop', 'type' => 'toggle', 'label' => __('Colorful Backdrop'), 'default' => true, 'tab' => 'style', 'help' => __('Gradient behind the glass so the blur effect is visible.')],
            [
                'name' => 'layout',
                'type' => 'select',
                'label' => __('Layout'),
                'default' => 'row',
                'tab' => 'style',
                'options' => [
                    'row' => __('Horizontal'),
                    'column' => __('Vertical'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'size',
                'type' => 'select',
                'label' => __('Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name' => 'shape',
                'type' => 'select',
                'label' => __('Shape'),
                'default' => 'circle',
                'tab' => 'style',
                'options' => [
                    'circle' => __('Circle'),
                    'rounded' => __('Rounded'),
                    'pill' => __('Pill'),
                ],
            ],
            ['name' => 'show_labels', 'type' => 'toggle', 'label' => __('Show Labels'), 'default' => false, 'tab' => 'style'],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#6366f1', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $labels = $this->flag($settings['show_labels'] ?? null, false);
        $shape = $this->pick($settings['shape'] ?? 'circle', ['circle', 'rounded', 'pill'], 'circle');

        // Yazı göstərilirsə dairə formasında yazı sığmaz, pill-ə keçirik
        if ($labels && $shape === 'circle') {
            $shape = 'pill';
        }

        $sizeKey = $this->pick($settings['size'] ?? 'md', ['sm', 'md', 'lg'], 'md');

        $opts = [
            'title' => trim((string) ($settings['title'] ?? '')),
            'show_title' => $this->flag($settings['show_title'] ?? null, true),
            'url' => $this->cleanUrl((string) ($settings['share_url'] ?? '')),
            'text' => mb_substr(trim((string) ($settings['share_text'] ?? '')), 0, 200),
            'style' => $this->pick($settings['style'] ?? 'glass', ['glass', 'glass-dark', 'outline'], 'glass'),
            'backdrop' => $this->flag($settings['show_backdrop'] ?? null, true),
            'layout' => $this->pick($settings['layout'] ?? 'row', ['row', 'column'], 'row'),
            'justify' => ['left' => 'flex-start', 'center' => 'center', 'right' => 'flex-end'][
                $this->pick($settings['align'] ?? 'center', ['left', 'center', 'right'], 'center')
            ],
            'size' => ['sm' => 36, 'md' => 44, 'lg' => 52][$sizeKey],
            'shape' => $shape,
            'labels' => $labels,
            'accent' => $this->hex($settings['accent_color'] ?? null, '#6366f1'),
        ];

        // Serverdə ehtiyat (fallback) dəyərlər: JS yüklənməsə də linklər işləsin
        $fallbackUrl = $opts['url'] !== '' ? $opts['url'] : request()->url();
        $site = function_exists('rj_get_option') ? trim((string) rj_get_option('site_name', '')) : '';
        $fallbackText = $opts['text'] !== '' ? $opts['text'] : $site;

        $networks = [];
        foreach ($this->catalog() as $key => $net) {
            if (!$this->flag($settings['net_' . $key] ?? null, $net['default'])) {
                continue;
            }

            $net['key'] = $key;
            $net['href'] = isset($net['tpl'])
                ? str_replace(
                    ['{url}', '{text}'],
                    [rawurlencode($fallbackUrl), rawurlencode($fallbackText)],
                    $net['tpl']
                )
                : '';
            $networks[] = $net;
        }

        if (empty($networks)) {
            return '';
        }

        $uid = 'share_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.share', [
            'o' => $opts,
            'networks' => $networks,
            'uid' => $uid,
        ])->render();
    }

    /**
     * Dəstəklənən şəbəkələr. tpl yoxdursa, bu düymə JS ilə işləyir (copy, native).
     */
    private function catalog(): array
    {
        return [
            'whatsapp' => [
                'label' => 'WhatsApp',
                'color' => '#25D366',
                'default' => true,
                'tpl' => 'https://wa.me/?text={text}%20{url}',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21l1.6-4.7A8.5 8.5 0 1 1 8 19.6L3 21z"/><path d="M9 9c.3 2 2.2 4 4.5 4.8l1.2-1.2-1.8-1-.8.6c-.8-.3-1.7-1.2-2-2l.6-.8-1-1.8L9 9z"/></svg>',
            ],
            'telegram' => [
                'label' => 'Telegram',
                'color' => '#229ED9',
                'default' => true,
                'tpl' => 'https://t.me/share/url?url={url}&text={text}',
                'svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.5 4.3L2.9 11.5c-.9.3-.9 1.2 0 1.5l4.7 1.5 1.8 5.5c.2.6.9.7 1.3.3l2.6-2.4 4.8 3.5c.6.4 1.3.1 1.5-.6L22.9 5.7c.2-.9-.6-1.7-1.4-1.4zM9 14l9.6-6-7.8 7.3-.3 3L9 14z"/></svg>',
            ],
            'facebook' => [
                'label' => 'Facebook',
                'color' => '#1877F2',
                'default' => true,
                'tpl' => 'https://www.facebook.com/sharer/sharer.php?u={url}',
                'svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5H16l.5-3h-3V8.6c0-.9.3-1.5 1.6-1.5h1.5V4.4c-.3 0-1.2-.1-2.2-.1-2.2 0-3.7 1.3-3.7 3.8v2.4H8.2v3h2.5V21h2.8z"/></svg>',
            ],
            'x' => [
                'label' => 'X',
                'color' => '#0f172a',
                'default' => true,
                'tpl' => 'https://twitter.com/intent/tweet?url={url}&text={text}',
                'svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.8 3h3L14.2 10.6 22 21h-6.1l-4.8-6.3L5.6 21H2.6l7-8.1L2.2 3h6.2l4.3 5.7L17.8 3zm-1.1 16.2h1.7L7.4 4.7H5.6l11.1 14.5z"/></svg>',
            ],
            'linkedin' => [
                'label' => 'LinkedIn',
                'color' => '#0A66C2',
                'default' => true,
                'tpl' => 'https://www.linkedin.com/sharing/share-offsite/?url={url}',
                'svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.5 9H3.5v11h3V9zM5 4a1.75 1.75 0 100 3.5A1.75 1.75 0 005 4zm4.5 5h2.9v1.5c.5-.9 1.7-1.8 3.4-1.8 3 0 3.7 2 3.7 4.6V20h-3v-5.8c0-1.4 0-2.9-1.9-2.9s-2.1 1.4-2.1 2.8V20h-3V9z"/></svg>',
            ],
            'email' => [
                'label' => 'Email',
                'color' => '#64748b',
                'default' => false,
                'tpl' => 'mailto:?subject={text}&body={url}',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>',
            ],
            'copy' => [
                'label' => __('Copy link'),
                'color' => '#6366f1',
                'default' => true,
                'svg' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 14a4 4 0 005.7 0l3-3a4 4 0 00-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 00-5.7 0l-3 3a4 4 0 005.7 5.7l1-1"/></svg>',
            ],
            'native' => [
                'label' => __('More'),
                'color' => '#f59e0b',
                'default' => true,
                'svg' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M8 7l4-4 4 4"/><path d="M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>',
            ],
        ];
    }

    private function cleanUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        if (str_starts_with($url, '/')) {
            return rtrim(request()->getSchemeAndHttpHost(), '/') . $url;
        }

        return preg_match('/^https?:\/\//i', $url) && filter_var($url, FILTER_VALIDATE_URL) ? $url : '';
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

    private function hex(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }
}