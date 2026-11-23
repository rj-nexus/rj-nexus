<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class BentoGridShowcaseWidget extends BaseWidget
{
    private const ICONS = [
        'star' => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z',
        'bolt' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',
        'shield' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
        'chart' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
        'users' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        'globe' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418',
        'heart' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z',
        'send' => 'M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5',
        'clock' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
        'sparkles' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z',
        'code' => 'M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5',
        'cart' => 'M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z',
        'phone' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z',
        'mail' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
        'lock' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z',
        'layers' => 'M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3',
        'trending' => 'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941',
        'check' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];

    public function id(): string
    {
        return 'bento-grid-showcase';
    }

    public function name(): string
    {
        return __('Bento Grid Showcase');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="10" height="10" rx="2"/><rect x="15" y="3" width="6" height="6" rx="2"/><rect x="15" y="11" width="6" height="10" rx="2"/><rect x="3" y="15" width="10" height="6" rx="2"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Modern bento card grid with mixed card sizes (1x1, 2x1, 1x2, 2x2), big animated numbers, icons, short text and a corner arrow. Cards reveal on scroll, tilt and glow under the cursor.');
    }

    public function schema(): array
    {
        $icons = ['none' => __('None')];
        foreach (array_keys(self::ICONS) as $key) {
            $icons[$key] = ucfirst($key);
        }

        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Section Title'), 'default' => __('Everything you need, in one place'), 'tab' => 'content'],
            ['name' => 'subtitle', 'type' => 'text', 'label' => __('Section Subtitle'), 'default' => __('A quick look at the numbers and features behind our work.'), 'tab' => 'content'],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Heading Alignment'),
                'default' => 'center',
                'tab' => 'content',
                'options' => ['left' => __('Left'), 'center' => __('Center')],
            ],
            [
                'name' => 'cards',
                'type' => 'repeater',
                'label' => __('Cards'),
                'tab' => 'content',
                'default' => [
                    ['size' => '2x2', 'style' => 'gradient', 'icon' => 'star', 'number' => '98%', 'title' => __('Customer satisfaction'), 'text' => __('Clients who would recommend us to a friend or colleague.'), 'badge' => __('Top rated'), 'link' => '', 'new_tab' => false, 'arrow' => true],
                    ['size' => '1x2', 'style' => 'light', 'icon' => 'layers', 'number' => '150+', 'title' => __('Projects delivered'), 'text' => __('From small landing pages to large platforms.'), 'badge' => '', 'link' => '', 'new_tab' => false, 'arrow' => true],
                    ['size' => '1x1', 'style' => 'dark', 'icon' => 'clock', 'number' => '24/7', 'title' => __('Support'), 'text' => '', 'badge' => '', 'link' => '', 'new_tab' => false, 'arrow' => true],
                    ['size' => '1x1', 'style' => 'accent', 'icon' => 'users', 'number' => '12K', 'title' => __('Happy users'), 'text' => '', 'badge' => '', 'link' => '', 'new_tab' => false, 'arrow' => true],
                    ['size' => '2x1', 'style' => 'soft', 'icon' => 'bolt', 'number' => '3x', 'title' => __('Faster delivery'), 'text' => __('Streamlined process, shorter timelines.'), 'badge' => '', 'link' => '', 'new_tab' => false, 'arrow' => true],
                    ['size' => '2x1', 'style' => 'dark', 'icon' => 'shield', 'number' => '99.9%', 'title' => __('Uptime'), 'text' => __('Reliable infrastructure you can count on.'), 'badge' => '', 'link' => '', 'new_tab' => false, 'arrow' => true],
                ],
                'fields' => [
                    [
                        'name' => 'size',
                        'type' => 'select',
                        'label' => __('Card Size'),
                        'default' => '1x1',
                        'options' => ['1x1' => '1 x 1', '2x1' => '2 x 1 (' . __('wide') . ')', '1x2' => '1 x 2 (' . __('tall') . ')', '2x2' => '2 x 2 (' . __('large') . ')'],
                    ],
                    [
                        'name' => 'style',
                        'type' => 'select',
                        'label' => __('Card Style'),
                        'default' => 'soft',
                        'options' => ['soft' => __('Soft'), 'dark' => __('Dark'), 'light' => __('Light'), 'accent' => __('Accent'), 'gradient' => __('Animated Gradient')],
                    ],
                    ['name' => 'icon', 'type' => 'select', 'label' => __('Icon'), 'default' => 'star', 'options' => $icons],
                    ['name' => 'number', 'type' => 'text', 'label' => __('Big Number'), 'default' => '', 'help' => __('Examples: 98%, $1.2M, 12K+, 1,250, 24/7. Numbers count up when the card appears.')],
                    ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => ''],
                    ['name' => 'text', 'type' => 'textarea', 'label' => __('Short Text'), 'default' => ''],
                    ['name' => 'badge', 'type' => 'text', 'label' => __('Badge (optional)'), 'default' => ''],
                    ['name' => 'link', 'type' => 'text', 'label' => __('Link (optional)'), 'default' => '', 'placeholder' => 'https://'],
                    ['name' => 'new_tab', 'type' => 'toggle', 'label' => __('Open in New Tab'), 'default' => false],
                    ['name' => 'arrow', 'type' => 'toggle', 'label' => __('Show Corner Arrow'), 'default' => true],
                ],
            ],

            [
                'name' => 'columns',
                'type' => 'select',
                'label' => __('Desktop Columns'),
                'default' => '4',
                'tab' => 'style',
                'options' => ['3' => '3', '4' => '4'],
            ],
            [
                'name' => 'gap',
                'type' => 'select',
                'label' => __('Gap'),
                'default' => 'md',
                'tab' => 'style',
                'options' => ['sm' => __('Small'), 'md' => __('Medium'), 'lg' => __('Large')],
            ],
            [
                'name' => 'radius',
                'type' => 'select',
                'label' => __('Corner Radius'),
                'default' => 'lg',
                'tab' => 'style',
                'options' => ['md' => __('Medium'), 'lg' => __('Large'), 'xl' => __('Extra Large')],
            ],
            [
                'name' => 'row_height',
                'type' => 'select',
                'label' => __('Row Height'),
                'default' => '190',
                'tab' => 'style',
                'options' => ['150' => __('Compact'), '190' => __('Normal'), '230' => __('Tall')],
            ],
            [
                'name' => 'theme',
                'type' => 'select',
                'label' => __('Page Theme'),
                'default' => 'dark',
                'tab' => 'style',
                'options' => ['dark' => __('Dark'), 'light' => __('Light')],
                'help' => __('Controls heading color and Soft cards. Pick the one that matches your page background.'),
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
            ['name' => 'accent_color_2', 'type' => 'color', 'label' => __('Second Accent Color'), 'default' => '#ec4899', 'tab' => 'style'],
            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Animations'), 'default' => true, 'tab' => 'style'],
            ['name' => 'tilt', 'type' => 'toggle', 'label' => __('3D Tilt on Hover'), 'default' => true, 'tab' => 'style'],
            ['name' => 'spotlight', 'type' => 'toggle', 'label' => __('Cursor Spotlight'), 'default' => true, 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $cards = $this->cards($settings['cards'] ?? []);
        if ($cards === []) {
            return '';
        }

        $gaps = ['sm' => 10, 'md' => 16, 'lg' => 24];
        $radii = ['md' => 20, 'lg' => 28, 'xl' => 36];

        $opts = [
            'title' => $this->text($settings['title'] ?? '', 140),
            'subtitle' => $this->text($settings['subtitle'] ?? '', 260),
            'align' => $this->pick($settings['align'] ?? 'center', ['left', 'center'], 'center'),
            'columns' => $this->pick($settings['columns'] ?? '4', ['3', '4'], '4'),
            'gap' => $gaps[$this->pick($settings['gap'] ?? 'md', array_keys($gaps), 'md')],
            'radius' => $radii[$this->pick($settings['radius'] ?? 'lg', array_keys($radii), 'lg')],
            'row' => (int) $this->pick($settings['row_height'] ?? '190', ['150', '190', '230'], '190'),
            'theme' => $this->pick($settings['theme'] ?? 'dark', ['dark', 'light'], 'dark'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#8b5cf6'),
            'accent2' => $this->hex($settings['accent_color_2'] ?? null, '#ec4899'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'tilt' => $this->flag($settings['tilt'] ?? null, true),
            'spotlight' => $this->flag($settings['spotlight'] ?? null, true),
        ];

        return view('rjbuilder.widgets.builtin.bento-grid-showcase', [
            'o' => $opts,
            'cards' => $cards,
            'uid' => 'bn_' . substr(md5(uniqid('', true)), 0, 8),
        ])->render();
    }

    private function cards(mixed $raw): array
    {
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }
        if (!is_array($raw)) {
            return [];
        }

        $out = [];
        foreach (array_slice(array_values($raw), 0, 24) as $row) {
            if (!is_array($row)) {
                continue;
            }

            $title = $this->text($row['title'] ?? '', 80);
            $text = $this->text($row['text'] ?? '', 220);
            $number = $this->number($this->text($row['number'] ?? '', 24));

            if ($title === '' && $text === '' && $number === null) {
                continue;
            }

            $icon = (string) ($row['icon'] ?? '');
            $url = $this->safeUrl((string) ($row['link'] ?? ''));

            $out[] = [
                'size' => $this->pick($row['size'] ?? '1x1', ['1x1', '2x1', '1x2', '2x2'], '1x1'),
                'style' => $this->pick($row['style'] ?? 'soft', ['soft', 'dark', 'light', 'accent', 'gradient'], 'soft'),
                'icon' => isset(self::ICONS[$icon]) ? $this->svg(self::ICONS[$icon]) : '',
                'num' => $number,
                'title' => $title,
                'text' => $text,
                'badge' => $this->text($row['badge'] ?? '', 24),
                'url' => $url,
                'tag' => $url !== '' ? 'a' : 'div',
                'new_tab' => $this->flag($row['new_tab'] ?? null, false),
                'arrow' => $this->flag($row['arrow'] ?? null, true),
                'delay' => min(count($out) * 80, 800),
            ];
        }

        return $out;
    }

    private function number(string $raw): ?array
    {
        if ($raw === '') {
            return null;
        }

        if (!preg_match('/^(.*?)(\d(?:[\d.,\s]*\d)?)(.*)$/u', $raw, $m)) {
            return ['count' => false, 'text' => $raw];
        }

        $digits = $m[2];
        $sep = (bool) preg_match('/[,\s]/', $digits);
        $clean = preg_replace('/[,\s]/', '', $digits) ?? '';

        if (substr_count($clean, '.') > 1 || !is_numeric($clean)) {
            return ['count' => false, 'text' => $raw];
        }

        $dec = str_contains($clean, '.') ? min(4, strlen(substr($clean, strpos($clean, '.') + 1))) : 0;
        $value = (float) $clean;

        return [
            'count' => true,
            'to' => $value,
            'dec' => $dec,
            'sep' => $sep,
            'pre' => $m[1],
            'suf' => $m[3],
            'text' => $m[1] . number_format($value, $dec, '.', $sep ? ',' : '') . $m[3],
        ];
    }

    private function svg(string $path): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="' . $path . '"/></svg>';
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim(strip_tags((string) $value)), 0, $max);
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '';
        }
        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '';
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

    private function hex(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }
}