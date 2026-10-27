<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class PriceTableWidget extends BaseWidget
{
    public function id(): string
    {
        return 'price-table';
    }

    public function name(): string
    {
        return __('Price Table');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4zM4 10h16M10 10v9M4 15h16"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A pricing table for comparing plans with features, price and CTA.');
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
                'default' => __('Pricing Plans'),
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
                'name'    => 'columns',
                'type'    => 'select',
                'label'   => __('Columns'),
                'default' => '3',
                'tab'     => 'style',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent2',
                'type'    => 'color',
                'label'   => __('Accent Gradient End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'card_radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'md'  => __('Medium'),
                    'xl'  => __('Large'),
                    '2xl' => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'hover_lift',
                'type'    => 'toggle',
                'label'   => __('Lift on Hover'),
                'default' => true,
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
                'name'   => 'plans',
                'type'   => 'repeater',
                'label'  => __('Plans'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'name',      'type' => 'text',     'label' => __('Plan Name')],
                    ['name' => 'tagline',   'type' => 'text',     'label' => __('Tagline')],
                    ['name' => 'price',     'type' => 'text',     'label' => __('Price')],
                    ['name' => 'period',    'type' => 'text',     'label' => __('Period (e.g. /month)')],
                    ['name' => 'features',  'type' => 'textarea', 'label' => __('Features (one per line)')],
                    ['name' => 'cta_label', 'type' => 'text',     'label' => __('Button Label')],
                    ['name' => 'cta_url',   'type' => 'text',     'label' => __('Button URL')],
                    ['name' => 'badge',     'type' => 'text',     'label' => __('Badge (e.g. "Popular")')],
                    ['name' => 'featured',  'type' => 'select',   'label' => __('Featured'), 'options' => ['0' => __('No'), '1' => __('Yes')]],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'pt_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.price-table', compact('settings', 'uid'))->render();
    }
}
