<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ProgressBarWidget extends BaseWidget
{
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
        return __('Display skills, project progress, or goals with animated progress bars.');
    }

    public function schema(): array
    {
        $schema = [
            [
                'name' => 'layout',
                'type' => 'select',
                'label' => __('Layout'),
                'default' => 'vertical',
                'tab' => 'style',
                'options' => [
                    'vertical' => __('Vertical List'),
                    'grid-2' => __('2 Columns Grid'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'modern',
                'tab' => 'style',
                'options' => [
                    'modern' => __('Modern (Rounded)'),
                    'minimal' => __('Minimal (Thin)'),
                    'thick' => __('Thick (Bold)'),
                ],
            ],
            [
                'name' => 'show_percent',
                'type' => 'toggle',
                'label' => __('Show Percentage'),
                'default' => true,
                'tab' => 'style',
            ],
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

        for ($i = 1; $i <= 5; $i++) {
            $schema[] = ['name' => 'p'.$i.'_label', 'type' => 'text', 'label' => __('Item '.$i.' - Label'), 'default' => $i === 1 ? __('PHP') : '', 'tab' => 'content'];
            $schema[] = ['name' => 'p'.$i.'_value', 'type' => 'number', 'label' => __('Item '.$i.' - Percentage (0-100)'), 'default' => $i === 1 ? 90 : '', 'tab' => 'content', 'min' => 0, 'max' => 100];
            $schema[] = ['name' => 'p'.$i.'_color', 'type' => 'color', 'label' => __('Item '.$i.' - Color'), 'default' => $i === 1 ? '#8b5cf6' : '#3b82f6', 'tab' => 'style'];
        }

        return $schema;
    }

    public function render(array $settings): string
    {
        $items = [];
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($settings['p'.$i.'_label'])) {
                $items[] = [
                    'label' => $settings['p'.$i.'_label'],
                    'value' => min(100, max(0, (int)($settings['p'.$i.'_value'] ?? 0))),
                    'color' => $settings['p'.$i.'_color'] ?? '#8b5cf6',
                ];
            }
        }

        if (empty($items)) {
            return '';
        }

        $uid = 'pbar_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.progress-bar', compact('settings', 'items', 'uid'))->render();
    }
}
