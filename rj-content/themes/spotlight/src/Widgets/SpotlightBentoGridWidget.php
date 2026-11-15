<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightBentoGridWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-bento-grid';
    }

    public function name(): string
    {
        return __('Spotlight Bento Grid');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A modern, masonry-style grid with varying box sizes to showcase features, stats, and images.');
    }

    public function contexts(): array
    {
        return ['page', 'block'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('Explore the Power of Our Platform'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'textarea',
                'label'   => __('Subtitle'),
                'default' => __('Everything you need to scale your business, packed into one powerful solution.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'items',
                'type'    => 'repeater',
                'label'   => __('Grid Items'),
                'tab'     => 'content',
                'fields'  => [
                    [
                        'name'    => 'title',
                        'type'    => 'text',
                        'label'   => __('Title'),
                    ],
                    [
                        'name'    => 'description',
                        'type'    => 'textarea',
                        'label'   => __('Description'),
                    ],
                    [
                        'name'    => 'image',
                        'type'    => 'image',
                        'label'   => __('Image (Optional)'),
                    ],
                    [
                        'name'    => 'icon',
                        'type'    => 'icon',
                        'label'   => __('Icon (Optional)'),
                    ],
                    [
                        'name'    => 'size',
                        'type'    => 'select',
                        'label'   => __('Box Size'),
                        'options' => [
                            '1x1' => __('Small (1x1)'),
                            '2x1' => __('Wide (2x1)'),
                            '1x2' => __('Tall (1x2)'),
                            '2x2' => __('Large (2x2)'),
                        ],
                        'default' => '1x1',
                    ],
                    [
                        'name'    => 'style',
                        'type'    => 'select',
                        'label'   => __('Background Style'),
                        'options' => [
                            'glass'    => __('Glassmorphism'),
                            'solid'    => __('Solid Dark'),
                            'gradient' => __('Gradient Glow'),
                        ],
                        'default' => 'glass',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'bg_' . substr(md5(uniqid('', true)), 0, 8);

        return view('spotlight::widgets.bento-grid', compact('settings', 'uid'))->render();
    }
}