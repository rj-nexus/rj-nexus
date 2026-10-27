<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class GalleryAdvancedWidget extends BaseWidget
{
    public function id(): string
    {
        return 'gallery-advanced';
    }

    public function name(): string
    {
        return __('Gallery (Advanced)');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h5a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM13 5a1 1 0 011-1h5a1 1 0 011 1v3a1 1 0 01-1 1h-5a1 1 0 01-1-1V5zM13 12a1 1 0 011-1h5a1 1 0 011 1v7a1 1 0 01-1 1h-5a1 1 0 01-1-1v-7zM4 15a1 1 0 011-1h5a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4z"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('An advanced gallery with categories, sorting, masonry layout and lightbox.');
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
                'name'    => 'show_sort',
                'type'    => 'toggle',
                'label'   => __('Show Sort Dropdown'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'masonry',
                'tab'     => 'style',
                'options' => [
                    'masonry' => __('Masonry'),
                    'grid'    => __('Uniform Grid'),
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
                'name'   => 'items',
                'type'   => 'repeater',
                'label'  => __('Gallery Items'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'image',    'type' => 'media', 'label' => __('Image')],
                    ['name' => 'title',    'type' => 'text',  'label' => __('Title')],
                    ['name' => 'category', 'type' => 'text',  'label' => __('Category')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'galadv_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.gallery-advanced', compact('settings', 'uid'))->render();
    }
}
