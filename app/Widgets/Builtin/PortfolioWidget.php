<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class PortfolioWidget extends BaseWidget
{
    public function id(): string
    {
        return 'portfolio';
    }

    public function name(): string
    {
        return __('Portfolio');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('A filterable portfolio gallery with hover overlays and a lightbox.');
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
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_filter',
                'type'    => 'toggle',
                'label'   => __('Show Category Filter'),
                'default' => true,
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
                'name'    => 'gap',
                'type'    => 'select',
                'label'   => __('Gap'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'aspect',
                'type'    => 'select',
                'label'   => __('Image Ratio'),
                'default' => '4/3',
                'tab'     => 'style',
                'options' => [
                    '1/1'  => __('Square'),
                    '4/3'  => __('Landscape'),
                    '3/4'  => __('Portrait'),
                    '16/9' => __('Wide'),
                ],
            ],
            [
                'name'   => 'items',
                'type'   => 'repeater',
                'label'  => __('Portfolio Items'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'image',    'type' => 'media', 'label' => __('Image')],
                    ['name' => 'title',    'type' => 'text',  'label' => __('Title')],
                    ['name' => 'category', 'type' => 'text',  'label' => __('Category')],
                    ['name' => 'link',     'type' => 'text',  'label' => __('Link URL')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'portfolio_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.portfolio', compact('settings', 'uid'))->render();
    }
}
