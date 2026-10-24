<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class HeroSlideWidget extends BaseWidget
{
    public function id(): string
    {
        return 'hero-slide';
    }

    public function name(): string
    {
        return __('Hero Slide');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('A full-width hero section with a background image, text overlay, and a customizable CTA button.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'image',
                'type' => 'media',
                'label' => __('Background Image'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title'),
                'default' => __('Welcome to Our Store'),
                'tab' => 'content',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => __('Discover our latest collection and elevate your style.'),
                'tab' => 'content',
            ],
            [
                'name' => 'btn_text',
                'type' => 'text',
                'label' => __('Button Text'),
                'default' => __('Shop Now'),
                'tab' => 'content',
            ],
            [
                'name' => 'btn_url',
                'type' => 'text',
                'label' => __('Button URL'),
                'default' => '/shop',
                'tab' => 'content',
            ],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Section Height'),
                'default' => 'min-h-[70vh]',
                'tab' => 'style',
                'options' => [
                    'min-h-[40vh]' => __('Small (40vh)'),
                    'min-h-[60vh]' => __('Medium (60vh)'),
                    'min-h-[70vh]' => __('Large (70vh)'),
                    'min-h-[90vh]' => __('Extra Large (90vh)'),
                    'min-h-screen' => __('Full Screen'),
                ]
            ],
            [
                'name' => 'overlay_color',
                'type' => 'color',
                'label' => __('Overlay Color'),
                'default' => '#000000',
                'tab' => 'style',
            ],
            [
                'name' => 'overlay_opacity',
                'type' => 'range',
                'label' => __('Overlay Opacity (%)'),
                'default' => 40,
                'min' => 0,
                'max' => 100,
                'tab' => 'style',
            ],
            [
                'name' => 'title_color',
                'type' => 'color',
                'label' => __('Title Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'subtitle_color',
                'type' => 'color',
                'label' => __('Subtitle Color'),
                'default' => '#f3f4f6',
                'tab' => 'style',
            ],
            [
                'name' => 'btn_bg',
                'type' => 'color',
                'label' => __('Button Background'),
                'default' => '#111827',
                'tab' => 'style',
            ],
            [
                'name' => 'btn_text_color',
                'type' => 'color',
                'label' => __('Button Text Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'btn_hover_bg',
                'type' => 'color',
                'label' => __('Button Hover Background'),
                'default' => '#374151',
                'tab' => 'style',
            ],
            [
                'name' => 'btn_hover_text_color',
                'type' => 'color',
                'label' => __('Button Hover Text Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('rjbuilder.widgets.builtin.hero-slide', compact('settings'))->render();
    }
}
