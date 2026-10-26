<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class BasicGalleryWidget extends BaseWidget
{
    public function id(): string
    {
        return 'basic-gallery';
    }

    public function name(): string
    {
        return __('Bento Gallery');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('A modern, puzzle-like bento grid gallery with a sleek lightbox.');
    }

    public function schema(): array
    {
        $schema = [
            ['name' => 'title', 'type' => 'text', 'label' => __('Section Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 'subtitle', 'type' => 'text', 'label' => __('Section Subtitle'), 'default' => '', 'tab' => 'content'],
            [
                'name' => 'gap',
                'type' => 'select',
                'label' => __('Grid Gap'),
                'default' => 'gap-4',
                'tab' => 'style',
                'options' => [
                    'gap-2' => __('Small'),
                    'gap-4' => __('Medium'),
                    'gap-6' => __('Large'),
                ]
            ],
            [
                'name' => 'radius',
                'type' => 'select',
                'label' => __('Border Radius'),
                'default' => 'rounded-2xl',
                'tab' => 'style',
                'options' => [
                    'rounded-none' => __('None'),
                    'rounded-xl' => __('Small'),
                    'rounded-2xl' => __('Medium'),
                    'rounded-3xl' => __('Large'),
                ]
            ],
        ];

        for ($i = 1; $i <= 5; $i++) {
            $schema[] = ['name' => 'img_'.$i, 'type' => 'media', 'label' => __('Image '.$i), 'default' => '', 'tab' => 'content'];
        }

        return $schema;
    }

    public function render(array $settings): string
    {
        $uid = 'gallery_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.basic-gallery', compact('settings', 'uid'))->render();
    }
}
