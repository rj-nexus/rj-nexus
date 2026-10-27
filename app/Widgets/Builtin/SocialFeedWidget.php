<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class SocialFeedWidget extends BaseWidget
{
    public function id(): string
    {
        return 'social-feed';
    }

    public function name(): string
    {
        return __('Social Feed');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A social feed grid supporting Twitter, Instagram and local platforms like Piokio, Dehliz and Reax.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Follow us'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => __('Latest from our social channels'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'grid',
                'tab'     => 'style',
                'options' => [
                    'grid'    => __('Grid'),
                    'masonry' => __('Masonry'),
                    'carousel'=> __('Carousel'),
                ],
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
                'label'   => __('Card Ratio'),
                'default' => '1/1',
                'tab'     => 'style',
                'options' => [
                    '1/1'  => __('Square'),
                    '4/3'  => __('Landscape'),
                    '3/4'  => __('Portrait'),
                    '16/9' => __('Wide'),
                ],
            ],
            [
                'name'    => 'show_platform',
                'type'    => 'toggle',
                'label'   => __('Show Platform Icon'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_caption',
                'type'    => 'toggle',
                'label'   => __('Show Caption'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_date',
                'type'    => 'toggle',
                'label'   => __('Show Date'),
                'default' => false,
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
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'xl'   => __('Extra Large'),
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
                'name'    => 'show_tabs',
                'type'    => 'toggle',
                'label'   => __('Show Platform Filter Tabs'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'items',
                'type'    => 'repeater',
                'label'   => __('Posts'),
                'tab'     => 'content',
                'fields' => [
                    ['name' => 'platform', 'type' => 'select', 'label' => __('Platform'), 'options' => [
                        'twitter'   => 'Twitter / X',
                        'instagram' => 'Instagram',
                        'piokio'    => 'Piokio',
                        'dehliz'    => 'Dehliz',
                        'reax'      => 'Reax',
                    ]],
                    ['name' => 'image',    'type' => 'media', 'label' => __('Image')],
                    ['name' => 'caption',  'type' => 'textarea', 'label' => __('Caption')],
                    ['name' => 'url',      'type' => 'text', 'label' => __('Post URL')],
                    ['name' => 'date',     'type' => 'text', 'label' => __('Date (e.g. 2026-10-27)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'sf_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.social-feed', compact('settings', 'uid'))->render();
    }
}
