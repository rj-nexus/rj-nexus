<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class HotspotWidget extends BaseWidget
{
    public function id(): string
    {
        return 'hotspot';
    }

    public function name(): string
    {
        return __('Hotspot');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('An image with interactive pulsing hotspots that reveal tooltips on hover or click.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'image',
                'type'    => 'media',
                'label'   => __('Background Image'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title (optional)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'trigger',
                'type'    => 'select',
                'label'   => __('Trigger'),
                'default' => 'hover',
                'tab'     => 'content',
                'options' => [
                    'hover' => __('Hover'),
                    'click' => __('Click'),
                    'both'  => __('Hover + Click'),
                ],
            ],
            [
                'name'    => 'dot_size',
                'type'    => 'select',
                'label'   => __('Dot Size'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'dot_color',
                'type'    => 'color',
                'label'   => __('Dot Color'),
                'default' => '#ef4444',
                'tab'     => 'style',
            ],
            [
                'name'    => 'dot_style',
                'type'    => 'select',
                'label'   => __('Dot Style'),
                'default' => 'ping',
                'tab'     => 'style',
                'options' => [
                    'ping'   => __('Ping Pulse'),
                    'ring'   => __('Ring Pulse'),
                    'solid'  => __('Solid'),
                    'bounce' => __('Bounce'),
                ],
            ],
            [
                'name'    => 'tooltip_theme',
                'type'    => 'select',
                'label'   => __('Tooltip Theme'),
                'default' => 'dark',
                'tab'     => 'style',
                'options' => [
                    'dark'   => __('Dark'),
                    'light'  => __('Light'),
                    'accent' => __('Accent (Dot Color)'),
                ],
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Image Radius'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'xl'   => __('Large'),
                    '2xl'  => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 40,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'    => 'hotspots',
                'type'    => 'repeater',
                'label'   => __('Hotspots'),
                'tab'     => 'content',
                'fields' => [
                    ['name' => 'x',      'type' => 'text',  'label' => __('X Position (0-100%)')],
                    ['name' => 'y',      'type' => 'text',  'label' => __('Y Position (0-100%)')],
                    ['name' => 'title',  'type' => 'text',  'label' => __('Title')],
                    ['name' => 'desc',   'type' => 'textarea', 'label' => __('Description')],
                    ['name' => 'image',  'type' => 'media', 'label' => __('Image (optional)')],
                    ['name' => 'link',   'type' => 'text',  'label' => __('Link (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'hs_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.hotspot', compact('settings', 'uid'))->render();
    }
}
