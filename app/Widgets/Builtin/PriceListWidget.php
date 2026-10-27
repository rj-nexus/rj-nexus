<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class PriceListWidget extends BaseWidget
{
    public function id(): string
    {
        return 'price-list';
    }

    public function name(): string
    {
        return __('Price List');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h8M4 12h8M4 18h8M16 6h4M16 12h4M16 18h4"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A restaurant menu or service price list with dotted leaders and hover-spinning icons or images.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Our Menu'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'desc',
                'type'    => 'textarea',
                'label'   => __('Section Description'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'image_shape',
                'type'    => 'select',
                'label'   => __('Icon/Image Shape'),
                'default' => 'circle',
                'tab'     => 'style',
                'options' => [
                    'circle'  => __('Circle'),
                    'rounded' => __('Rounded Square'),
                    'square'  => __('Square'),
                ],
            ],
            [
                'name'    => 'show_leaders',
                'type'    => 'toggle',
                'label'   => __('Show Dotted Leaders'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'leader_style',
                'type'    => 'select',
                'label'   => __('Leader Style'),
                'default' => 'dotted',
                'tab'     => 'style',
                'options' => [
                    'dotted' => __('Dotted'),
                    'dashed' => __('Dashed'),
                    'solid'  => __('Solid'),
                ],
            ],
            [
                'name'    => 'hover_spin',
                'type'    => 'toggle',
                'label'   => __('Spin Icon on Hover'),
                'default' => true,
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
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'columns',
                'type'    => 'select',
                'label'   => __('Columns'),
                'default' => '1',
                'tab'     => 'style',
                'options' => [
                    '1' => __('1 Column'),
                    '2' => __('2 Columns'),
                ],
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
                'name'   => 'items',
                'type'   => 'repeater',
                'label'  => __('Menu Items'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'title',  'type' => 'text', 'label' => __('Item Name')],
                    ['name' => 'desc',   'type' => 'text', 'label' => __('Short Description')],
                    ['name' => 'price',  'type' => 'text', 'label' => __('Price')],
                    ['name' => 'icon',   'type' => 'icon', 'label' => __('Icon')],
                    ['name' => 'image',  'type' => 'media', 'label' => __('Image (optional)')],
                    ['name' => 'badge',  'type' => 'text', 'label' => __('Badge (e.g. "New")')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'pl_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.price-list', compact('settings', 'uid'))->render();
    }
}
