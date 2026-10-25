<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ToggleCardsWidget extends BaseWidget
{
    private const MAX_CARDS = 12;

    private const PALETTE = ['#8b5cf6', '#06b6d4', '#f59e0b', '#10b981', '#ec4899', '#3b82f6'];

    public function id(): string
    {
        return 'toggle-cards';
    }

    public function name(): string
    {
        return __('Toggle Cards');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Interactive cards that expand or flip in 3D to reveal hidden content.');
    }

    public function schema(): array
    {
        return [
            // ---------- Content ----------
            ['name' => 'section_title', 'type' => 'text', 'label' => __('Section Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 'section_subtitle', 'type' => 'text', 'label' => __('Subtitle'), 'default' => '', 'tab' => 'content'],

            ['name' => 'c1_icon', 'type' => 'icon', 'label' => __('Card 1 - Icon'), 'default' => 'ph:sparkle', 'tab' => 'content'],
            ['name' => 'c1_title', 'type' => 'text', 'label' => __('Card 1 - Title'), 'default' => __('Premium Quality'), 'tab' => 'content'],
            ['name' => 'c1_excerpt', 'type' => 'text', 'label' => __('Card 1 - Short Excerpt'), 'default' => __('Crafted with the finest materials.'), 'tab' => 'content'],
            ['name' => 'c1_content', 'type' => 'textarea', 'label' => __('Card 1 - Expanded Content'), 'default' => __('Our products are meticulously designed and manufactured using only the highest grade materials to ensure longevity and unparalleled quality.'), 'tab' => 'content', 'help' => __('Optional button: make the LAST line  >> Button text | /url')],

            ['name' => 'c2_icon', 'type' => 'icon', 'label' => __('Card 2 - Icon'), 'default' => 'ph:truck', 'tab' => 'content'],
            ['name' => 'c2_title', 'type' => 'text', 'label' => __('Card 2 - Title'), 'default' => __('Fast Shipping'), 'tab' => 'content'],
            ['name' => 'c2_excerpt', 'type' => 'text', 'label' => __('Card 2 - Short Excerpt'), 'default' => __('Delivered to your door in days.'), 'tab' => 'content'],
            ['name' => 'c2_content', 'type' => 'textarea', 'label' => __('Card 2 - Expanded Content'), 'default' => __('We offer express shipping options worldwide, ensuring your order reaches you as quickly as possible, no matter where you are located.'), 'tab' => 'content'],

            ['name' => 'c3_icon', 'type' => 'icon', 'label' => __('Card 3 - Icon'), 'default' => 'ph:shield-check', 'tab' => 'content'],
            ['name' => 'c3_title', 'type' => 'text', 'label' => __('Card 3 - Title'), 'default' => __('Secure Shopping'), 'tab' => 'content'],
            ['name' => 'c3_excerpt', 'type' => 'text', 'label' => __('Card 3 - Short Excerpt'), 'default' => __('100% safe and encrypted.'), 'tab' => 'content'],
            ['name' => 'c3_content', 'type' => 'textarea', 'label' => __('Card 3 - Expanded Content'), 'default' => __('Your privacy and security are our top priorities. We use industry-standard SSL encryption to protect your personal and payment information.'), 'tab' => 'content'],

            ['name' => 'c4_icon', 'type' => 'icon', 'label' => __('Card 4 - Icon'), 'default' => '', 'tab' => 'content'],
            ['name' => 'c4_title', 'type' => 'text', 'label' => __('Card 4 - Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 'c4_excerpt', 'type' => 'text', 'label' => __('Card 4 - Short Excerpt'), 'default' => '', 'tab' => 'content'],
            ['name' => 'c4_content', 'type' => 'textarea', 'label' => __('Card 4 - Expanded Content'), 'default' => '', 'tab' => 'content'],

            [
                'name' => 'extra_cards',
                'type' => 'textarea',
                'label' => __('Extra Cards'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => "ph:gift | Title | Short excerpt | #ec4899\nExpanded content...\n>> Learn more | /about\n---\nph:star | Another card | Excerpt\nMore content...",
                'help' => __('Up to 12 cards in total. First line: "icon | title | excerpt | #color" (icon, excerpt and color are optional). Following lines = content. Separate cards with a line containing only ---'),
            ],
            ['name' => 'open_first', 'type' => 'toggle', 'label' => __('Open First Card by Default'), 'default' => false, 'tab' => 'content'],
            ['name' => 'single_open', 'type' => 'toggle', 'label' => __('Only One Open at a Time'), 'default' => false, 'tab' => 'content'],

            // ---------- Style ----------
            [
                'name' => 'mode',
                'type' => 'select',
                'label' => __('Reveal Effect'),
                'default' => 'expand',
                'tab' => 'style',
                'options' => [
                    'expand' => __('Expand (slide down)'),
                    'flip' => __('Flip (3D turn)'),
                ],
            ],
            [
                'name' => 'columns',
                'type' => 'select',
                'label' => __('Columns'),
                'default' => '3',
                'tab' => 'style',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Card Style'),
                'default' => 'light',
                'tab' => 'style',
                'options' => [
                    'light' => __('Light Shadow'),
                    'bordered' => __('Bordered'),
                    'dark' => __('Dark Theme'),
                    'gradient' => __('Gradient (fills when open)'),
                ],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
            ['name' => 'multicolor', 'type' => 'toggle', 'label' => __('Colorful Cards (auto palette)'), 'default' => false, 'tab' => 'style'],
            ['name' => 'show_numbers', 'type' => 'toggle', 'label' => __('Show Big Numbers (01, 02...)'), 'default' => true, 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $cards = [];

        for ($i = 1; $i <= 4; $i++) {
            $title = trim((string) ($settings['c' . $i . '_title'] ?? ''));
            if ($title !== '') {
                $cards[] = [
                    'icon' => trim((string) ($settings['c' . $i . '_icon'] ?? '')),
                    'title' => $title,
                    'excerpt' => trim((string) ($settings['c' . $i . '_excerpt'] ?? '')),
                    'content' => (string) ($settings['c' . $i . '_content'] ?? ''),
                    'color' => '',
                ];
            }
        }

        foreach ($this->parseExtra((string) ($settings['extra_cards'] ?? '')) as $extra) {
            $cards[] = $extra;
        }

        $cards = array_slice($cards, 0, self::MAX_CARDS);

        if (empty($cards)) {
            return '';
        }

        $multi = $this->toBool($settings['multicolor'] ?? null, false);

        foreach ($cards as $i => &$card) {
            [$card['text'], $card['cta']] = $this->splitCta((string) $card['content']);

            if ($card['color'] === '' && $multi) {
                $card['color'] = self::PALETTE[$i % count(self::PALETTE)];
            }
        }
        unset($card);

        $opts = [
            'title' => trim((string) ($settings['section_title'] ?? '')),
            'subtitle' => trim((string) ($settings['section_subtitle'] ?? '')),
            'mode' => $this->pick($settings['mode'] ?? 'expand', ['expand', 'flip'], 'expand'),
            'cols' => $this->pick($settings['columns'] ?? '3', ['2', '3', '4'], '3'),
            'style' => $this->pick($settings['style'] ?? 'light', ['light', 'bordered', 'dark', 'gradient'], 'light'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#8b5cf6'),
            'numbers' => $this->toBool($settings['show_numbers'] ?? null, true),
            'first' => $this->toBool($settings['open_first'] ?? null, false),
            'single' => $this->toBool($settings['single_open'] ?? null, false),
        ];

        $uid = 'tcard_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.toggle-cards', compact('cards', 'opts', 'uid'))->render();
    }

    private function parseExtra(string $raw): array
    {
        $raw = trim($raw);
        if ($raw === '') {
            return [];
        }

        $out = [];

        foreach (preg_split('/\R\s*---\s*\R/u', $raw) ?: [] as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }

            $parts = preg_split('/\R/u', $block, 2);
            $fields = array_map('trim', explode('|', (string) ($parts[0] ?? '')));

            $icon = '';
            if (count($fields) > 1 && preg_match('/^[a-z0-9_-]+:[a-z0-9_-]+$/i', $fields[0])) {
                $icon = array_shift($fields);
            }

            $title = $fields[0] ?? '';
            if ($title === '' || $title === '---') {
                continue;
            }

            $color = '';
            if (isset($fields[2]) && preg_match('/^#(?:[0-9a-f]{3}|[0-9a-f]{6})$/i', $fields[2])) {
                $color = $fields[2];
            }

            $out[] = [
                'icon' => $icon,
                'title' => $title,
                'excerpt' => $fields[1] ?? '',
                'content' => trim($parts[1] ?? ''),
                'color' => $color,
            ];
        }

        return $out;
    }

    /**
     * If the last line is ">> Label | url", pull it out as a call-to-action button.
     *
     * @return array{0: string, 1: array{label: string, url: string}|null}
     */
    private function splitCta(string $content): array
    {
        $content = rtrim($content);
        if ($content === '') {
            return ['', null];
        }

        $lines = preg_split('/\R/u', $content) ?: [];
        $last = trim((string) end($lines));

        if (preg_match('/^>>\s*(.+?)\s*\|\s*(\S+)$/u', $last, $m)) {
            $url = $this->safeUrl($m[2]);
            if ($url !== '') {
                array_pop($lines);

                return [trim(implode("\n", $lines)), ['label' => $m[1], 'url' => $url]];
            }
        }

        return [trim($content), null];
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

    private function toBool(mixed $value, bool $default): bool
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
