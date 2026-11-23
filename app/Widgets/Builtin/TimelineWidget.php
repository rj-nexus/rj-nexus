<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class TimelineWidget extends BaseWidget
{
    private const MAX_ITEMS = 30;

    public function id(): string
    {
        return 'timeline';
    }

    public function name(): string
    {
        return __('Timeline');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18"/><circle cx="12" cy="7" r="2"/><circle cx="12" cy="17" r="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 7h6M4 17h6"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Vertical timeline with scroll progress and reveal animation.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'items',
                'type' => 'textarea',
                'label' => __('Timeline Items'),
                'default' => "2020 | Company founded | The first office opened.\n2022 | 100 customers | The team grew to 10 people.\n2024 | New platform | Launched the next generation product.",
                'tab' => 'content',
                'rows' => 8,
                'help' => __('One item per line. Format: Date | Title | Description (description is optional).'),
            ],

            [
                'name' => 'layout',
                'type' => 'select',
                'label' => __('Layout'),
                'default' => 'alternate',
                'tab' => 'style',
                'options' => [
                    'alternate' => __('Alternating (left / right)'),
                    'left' => __('One side'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'card',
                'tab' => 'style',
                'options' => [
                    'card' => __('Card'),
                    'minimal' => __('Minimal'),
                    'dark' => __('Dark Theme'),
                ],
            ],
            [
                'name' => 'marker',
                'type' => 'select',
                'label' => __('Marker'),
                'default' => 'dot',
                'tab' => 'style',
                'options' => [
                    'dot' => __('Dot'),
                    'number' => __('Number'),
                ],
            ],
            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Scroll Animation'), 'default' => true, 'tab' => 'style'],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#6366f1', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $items = $this->parseItems((string) ($settings['items'] ?? ''));

        if (empty($items)) {
            return '';
        }

        $opts = [
            'layout' => $this->pick($settings['layout'] ?? 'alternate', ['alternate', 'left'], 'alternate'),
            'style' => $this->pick($settings['style'] ?? 'card', ['card', 'minimal', 'dark'], 'card'),
            'marker' => $this->pick($settings['marker'] ?? 'dot', ['dot', 'number'], 'dot'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#6366f1'),
        ];

        $uid = 'tl_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.timeline', [
            'o' => $opts,
            'items' => $items,
            'uid' => $uid,
        ])->render();
    }

    /**
     * "Tarix | Başlıq | Təsvir" formatındakı sətirləri massivə çevirir.
     */
    private function parseItems(string $raw): array
    {
        $items = [];

        foreach (preg_split('/\R/u', $raw) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line, 3));

            $date = $parts[0] ?? '';
            $title = $parts[1] ?? '';
            $text = $parts[2] ?? '';

            // Yalnız bir hissə yazılıbsa, onu başlıq sayırıq
            if (count($parts) === 1) {
                $title = $date;
                $date = '';
            }

            if ($title === '' && $text === '' && $date === '') {
                continue;
            }

            $items[] = [
                'date' => mb_substr($date, 0, 60),
                'title' => mb_substr($title, 0, 160),
                'text' => mb_substr($text, 0, 600),
            ];

            if (count($items) >= self::MAX_ITEMS) {
                break;
            }
        }

        return $items;
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