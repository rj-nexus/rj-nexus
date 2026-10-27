<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class LogoGridWidget extends BaseWidget
{
    public function id(): string
    {
        return 'logo-grid';
    }

    public function name(): string
    {
        return __('Logo Grid / Carousel');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('A grid or infinite marquee of partner logos with grayscale-on-hover effect.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Trusted by teams worldwide'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'grid',
                'tab'     => 'content',
                'options' => [
                    'grid'     => __('Static Grid'),
                    'marquee'  => __('Infinite Marquee'),
                    'carousel' => __('Carousel (scrollable)'),
                ],
            ],
            [
                'name'    => 'columns',
                'type'    => 'select',
                'label'   => __('Columns (grid only)'),
                'default' => '4',
                'tab'     => 'style',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                    '5' => __('5 Columns'),
                    '6' => __('6 Columns'),
                ],
            ],
            [
                'name'    => 'logo_height',
                'type'    => 'range',
                'label'   => __('Logo Height (px)'),
                'default' => 60,
                'min'     => 30,
                'max'     => 140,
                'step'    => 2,
                'tab'     => 'style',
            ],
            [
                'name'    => 'grayscale',
                'type'    => 'toggle',
                'label'   => __('Grayscale by Default'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'hover_effect',
                'type'    => 'select',
                'label'   => __('Hover Effect'),
                'default' => 'color',
                'tab'     => 'style',
                'options' => [
                    'color'  => __('Restore Color'),
                    'scale'  => __('Scale Up'),
                    'lift'   => __('Lift + Shadow'),
                    'glow'   => __('Glow Frame'),
                    'none'   => __('None'),
                ],
            ],
            [
                'name'    => 'card_style',
                'type'    => 'select',
                'label'   => __('Card Style'),
                'default' => 'plain',
                'tab'     => 'style',
                'options' => [
                    'plain' => __('Plain'),
                    'boxed' => __('Boxed'),
                    'ring'  => __('Ring Border'),
                ],
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'center',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                ],
            ],
            [
                'name'    => 'bg_color',
                'type'    => 'color',
                'label'   => __('Background'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'marquee_speed',
                'type'    => 'range',
                'label'   => __('Marquee Speed (seconds per loop)'),
                'default' => 30,
                'min'     => 10,
                'max'     => 90,
                'step'    => 5,
                'tab'     => 'style',
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 60,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'   => 'logos',
                'type'   => 'repeater',
                'label'  => __('Logos'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'image', 'type' => 'media', 'label' => __('Logo Image')],
                    ['name' => 'name',  'type' => 'text',  'label' => __('Company Name (alt)')],
                    ['name' => 'url',   'type' => 'text',  'label' => __('Link URL (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'lg_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.logo-grid', compact('settings', 'uid'))->render();
    }
}
