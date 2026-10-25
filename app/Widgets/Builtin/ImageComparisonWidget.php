<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ImageComparisonWidget extends BaseWidget
{
    public function id(): string
    {
        return 'image-comparison';
    }

    public function name(): string
    {
        return __('Image Comparison');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('A draggable slider to compare two images (Before & After).');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'before_image',
                'type' => 'media',
                'label' => __('Before Image'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'after_image',
                'type' => 'media',
                'label' => __('After Image'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'before_label',
                'type' => 'text',
                'label' => __('Before Label'),
                'default' => __('Before'),
                'tab' => 'content',
            ],
            [
                'name' => 'after_label',
                'type' => 'text',
                'label' => __('After Label'),
                'default' => __('After'),
                'tab' => 'content',
            ],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Height'),
                'default' => 'aspect-video',
                'tab' => 'style',
                'options' => [
                    'aspect-video' => __('Standard (16:9)'),
                    'aspect-square' => __('Square (1:1)'),
                    'aspect-[4/3]' => __('Classic (4:3)'),
                    'h-[400px]' => __('Fixed (400px)'),
                ],
            ],
            [
                'name' => 'slider_color',
                'type' => 'color',
                'label' => __('Slider Line & Handle Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'show_labels',
                'type' => 'toggle',
                'label' => __('Show Labels'),
                'default' => true,
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        if (empty($settings['before_image']) || empty($settings['after_image'])) {
            return '<div class="p-8 text-center text-gray-500 bg-gray-100 rounded-lg">' . __('Please select both Before and After images.') . '</div>';
        }

        $uid = 'imgcomp_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.image-comparison', compact('settings', 'uid'))->render();
    }
}
