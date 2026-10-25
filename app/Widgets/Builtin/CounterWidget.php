<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CounterWidget extends BaseWidget
{
    public function id(): string
    {
        return 'counter';
    }

    public function name(): string
    {
        return __('Animated Counters');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>';
    }

    public function category(): string
    {
        return 'marketing';
    }

    public function description(): string
    {
        return __('Animated numbers that count up when scrolled into view.');
    }

    public function schema(): array
    {
        return [
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
                'label' => __('Style'),
                'default' => 'light',
                'tab' => 'style',
                'options' => [
                    'light' => __('Light Background'),
                    'dark' => __('Dark Background'),
                    'transparent' => __('Transparent'),
                ],
            ],
            [
                'name' => 'accent_color',
                'type' => 'color',
                'label' => __('Number Accent Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'duration',
                'type' => 'number',
                'label' => __('Animation Duration (ms)'),
                'default' => 2000,
                'tab' => 'style',
            ],

            // Item 1
            ['name' => 'i1_icon', 'type' => 'icon', 'label' => __('Item 1 - Icon'), 'default' => 'ph:users', 'tab' => 'content'],
            ['name' => 'i1_number', 'type' => 'text', 'label' => __('Item 1 - Number'), 'default' => '500', 'tab' => 'content'],
            ['name' => 'i1_suffix', 'type' => 'text', 'label' => __('Item 1 - Suffix (e.g. + or %)'), 'default' => '+', 'tab' => 'content'],
            ['name' => 'i1_label', 'type' => 'text', 'label' => __('Item 1 - Label'), 'default' => __('Happy Customers'), 'tab' => 'content'],

            // Item 2
            ['name' => 'i2_icon', 'type' => 'icon', 'label' => __('Item 2 - Icon'), 'default' => 'ph:briefcase', 'tab' => 'content'],
            ['name' => 'i2_number', 'type' => 'text', 'label' => __('Item 2 - Number'), 'default' => '10', 'tab' => 'content'],
            ['name' => 'i2_suffix', 'type' => 'text', 'label' => __('Item 2 - Suffix'), 'default' => '', 'tab' => 'content'],
            ['name' => 'i2_label', 'type' => 'text', 'label' => __('Item 2 - Label'), 'default' => __('Years Experience'), 'tab' => 'content'],

            // Item 3
            ['name' => 'i3_icon', 'type' => 'icon', 'label' => __('Item 3 - Icon'), 'default' => 'ph:star', 'tab' => 'content'],
            ['name' => 'i3_number', 'type' => 'text', 'label' => __('Item 3 - Number'), 'default' => '99', 'tab' => 'content'],
            ['name' => 'i3_suffix', 'type' => 'text', 'label' => __('Item 3 - Suffix'), 'default' => '%', 'tab' => 'content'],
            ['name' => 'i3_label', 'type' => 'text', 'label' => __('Item 3 - Label'), 'default' => __('Satisfaction Rate'), 'tab' => 'content'],

            // Item 4
            ['name' => 'i4_icon', 'type' => 'icon', 'label' => __('Item 4 - Icon'), 'default' => '', 'tab' => 'content'],
            ['name' => 'i4_number', 'type' => 'text', 'label' => __('Item 4 - Number'), 'default' => '', 'tab' => 'content'],
            ['name' => 'i4_suffix', 'type' => 'text', 'label' => __('Item 4 - Suffix'), 'default' => '', 'tab' => 'content'],
            ['name' => 'i4_label', 'type' => 'text', 'label' => __('Item 4 - Label'), 'default' => '', 'tab' => 'content'],
        ];
    }

    public function render(array $settings): string
    {
        $items = [];
        for ($i = 1; $i <= 4; $i++) {
            if (isset($settings['i'.$i.'_number']) && $settings['i'.$i.'_number'] !== '') {
                $items[] = [
                    'icon' => $settings['i'.$i.'_icon'] ?? '',
                    'number' => $settings['i'.$i.'_number'],
                    'suffix' => $settings['i'.$i.'_suffix'] ?? '',
                    'label' => $settings['i'.$i.'_label'] ?? '',
                ];
            }
        }

        if (empty($items)) {
            return '';
        }

        $uid = 'counter_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.counter', compact('settings', 'items', 'uid'))->render();
    }
}
