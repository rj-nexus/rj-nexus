<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ProgressBarWidget extends BaseWidget
{
    private const MAX_ITEMS = 8;

    private const HEIGHTS = ['h-2' => 8, 'h-3' => 12, 'h-4' => 16, 'h-6' => 24];

    /** Ring circumference for r = 52 (2 * PI * 52). */
    private const CIRC = 326.726;

    public function id(): string
    {
        return 'progress-bar';
    }

    public function name(): string
    {
        return __('Progress Bars');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Animated progress bars or circular rings with icons, for skills, goals and stats.');
    }

    public function schema(): array
    {
        $schema = [
            ['name' => 'section_title', 'type' => 'text', 'label' => __('Section Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 'section_subtitle', 'type' => 'text', 'label' => __('Subtitle'), 'default' => '', 'tab' => 'content'],
            [
                'name' => 'layout',
                'type' => 'select',
                'label' => __('Layout'),
                'default' => 'grid',
                'tab' => 'style',
                'options' => [
                    'grid' => __('Horizontal Grid'),
                    'circles' => __('Circles'),
                ],
            ],
            [
                'name' => 'columns',
                'type' => 'select',
                'label' => __('Columns'),
                'default' => '4',
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
                'label' => __('Bar Style'),
                'default' => 'modern',
                'tab' => 'style',
                'options' => [
                    'modern' => __('Modern (Rounded)'),
                    'minimal' => __('Minimal (Thin)'),
                    'thick' => __('Thick (Bold)'),
                ],
            ],
            ['name' => 'show_percent', 'type' => 'toggle', 'label' => __('Show Percentage'), 'default' => true, 'tab' => 'style'],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Bar Height'),
                'default' => 'h-3',
                'tab' => 'style',
                'options' => [
                    'h-2' => __('Thin (8px)'),
                    'h-3' => __('Medium (12px)'),
                    'h-4' => __('Thick (16px)'),
                    'h-6' => __('Extra Thick (24px)'),
                ],
            ],
        ];

        for ($i = 1; $i <= 8; $i++) {
            $schema[] = ['name' => 'p' . $i . '_icon', 'type' => 'icon', 'label' => __('Item ' . $i . ' - Icon'), 'default' => $i === 1 ? 'ph:code' : '', 'tab' => 'content'];
            $schema[] = ['name' => 'p' . $i . '_label', 'type' => 'text', 'label' => __('Item ' . $i . ' - Label'), 'default' => $i === 1 ? __('PHP') : '', 'tab' => 'content'];
            $schema[] = ['name' => 'p' . $i . '_value', 'type' => 'number', 'label' => __('Item ' . $i . ' - Percentage (0-100)'), 'default' => $i === 1 ? 90 : '', 'tab' => 'content', 'min' => 0, 'max' => 100];
            $schema[] = ['name' => 'p' . $i . '_color', 'type' => 'color', 'label' => __('Item ' . $i . ' - Color'), 'default' => $i === 1 ? '#8b5cf6' : '#3b82f6', 'tab' => 'style'];
        }

        return $schema;
    }

    public function render(array $settings): string
    {
        $items = [];

        for ($i = 1; $i <= 8; $i++) {
            $label = trim((string) ($settings['p' . $i . '_label'] ?? ''));
            if ($label === '') {
                continue;
            }

            $items[] = [
                'icon' => trim((string) ($settings['p' . $i . '_icon'] ?? '')),
                'label' => $label,
                'value' => max(0, min(100, (int) ($settings['p' . $i . '_value'] ?? 0))),
                'color' => $this->hex($settings['p' . $i . '_color'] ?? null, '#8b5cf6'),
            ];
        }

        $items = array_slice($items, 0, self::MAX_ITEMS);

        if (empty($items)) {
            return '';
        }

        foreach ($items as &$it) {
            $it['off'] = round(self::CIRC * (1 - $it['value'] / 100), 2);
        }
        unset($it);

        $style = $this->pick($settings['style'] ?? 'modern', ['modern', 'minimal', 'thick'], 'modern');
        $barH = self::HEIGHTS[$settings['height'] ?? 'h-3'] ?? 12;

        if ($style === 'minimal') {
            $barH = min($barH, 6);
        } elseif ($style === 'thick') {
            $barH = max($barH, 22);
        }

        $opts = [
            'title' => trim((string) ($settings['section_title'] ?? '')),
            'subtitle' => trim((string) ($settings['section_subtitle'] ?? '')),
            'layout' => $this->pick($settings['layout'] ?? 'grid', ['grid', 'circles'], 'grid'),
            'cols' => $this->pick($settings['columns'] ?? '4', ['2', '3', '4'], '4'),
            'style' => $style,
            'percent' => $this->toBool($settings['show_percent'] ?? null, true),
            'bar_h' => $barH,
            'ring_w' => ['modern' => 9, 'minimal' => 5, 'thick' => 14][$style],
            'circ' => self::CIRC,
        ];

        $uid = 'pbar_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.progress-bar', compact('items', 'opts', 'uid'))->render();
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
