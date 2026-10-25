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
        return __('Hero Slider');
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
        return __('A full-width slider hero with up to 3 slides, text overlays, and CTA buttons.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Hero Size'),
                'default' => 'aspect-[21/9]',
                'tab' => 'content',
                'options' => [
                    'aspect-video' => __('Standard (16:9)'),
                    'aspect-[21/9]' => __('Cinematic (21:9)'),
                    'h-[500px]' => __('Fixed Medium (500px)'),
                    'h-[700px]' => __('Fixed Large (700px)'),
                    'min-h-screen' => __('Full Screen'),
                ]
            ],
            [
                'name' => 'image_position',
                'type' => 'select',
                'label' => __('Image Focus Point'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'center' => __('Center'),
                    'top' => __('Top'),
                    'bottom' => __('Bottom'),
                ]
            ],
            [
                'name' => 'image_blur',
                'type' => 'range',
                'label' => __('Image Blur (px)'),
                'default' => 0,
                'min' => 0,
                'max' => 20,
                'tab' => 'style',
            ],
            [
                'name' => 'transition_duration',
                'type' => 'number',
                'label' => __('Slide Transition Speed (ms)'),
                'default' => 1000,
                'tab' => 'style',
            ],
            [
                'name' => 'autoplay_speed',
                'type' => 'number',
                'label' => __('Autoplay Delay (ms)'),
                'default' => 5000,
                'tab' => 'style',
                'help' => __('Set to 0 to disable autoplay.')
            ],

            // Slide 1
            ['name' => 's1_image', 'type' => 'media', 'label' => __('Slide 1 - Image'), 'default' => '', 'tab' => 'content'],
            ['name' => 's1_title', 'type' => 'text', 'label' => __('Slide 1 - Title'), 'default' => __('Welcome to Our Store'), 'tab' => 'content'],
            ['name' => 's1_subtitle', 'type' => 'textarea', 'label' => __('Slide 1 - Subtitle'), 'default' => __('Discover our latest collection.'), 'tab' => 'content'],
            ['name' => 's1_btn_text', 'type' => 'text', 'label' => __('Slide 1 - Button Text'), 'default' => __('Shop Now'), 'tab' => 'content'],
            ['name' => 's1_btn_url', 'type' => 'text', 'label' => __('Slide 1 - Button URL'), 'default' => '/shop', 'tab' => 'content'],

            // Slide 2
            ['name' => 's2_image', 'type' => 'media', 'label' => __('Slide 2 - Image'), 'default' => '', 'tab' => 'content'],
            ['name' => 's2_title', 'type' => 'text', 'label' => __('Slide 2 - Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 's2_subtitle', 'type' => 'textarea', 'label' => __('Slide 2 - Subtitle'), 'default' => '', 'tab' => 'content'],
            ['name' => 's2_btn_text', 'type' => 'text', 'label' => __('Slide 2 - Button Text'), 'default' => __('View Collection'), 'tab' => 'content'],
            ['name' => 's2_btn_url', 'type' => 'text', 'label' => __('Slide 2 - Button URL'), 'default' => '/shop', 'tab' => 'content'],

            // Slide 3
            ['name' => 's3_image', 'type' => 'media', 'label' => __('Slide 3 - Image'), 'default' => '', 'tab' => 'content'],
            ['name' => 's3_title', 'type' => 'text', 'label' => __('Slide 3 - Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 's3_subtitle', 'type' => 'textarea', 'label' => __('Slide 3 - Subtitle'), 'default' => '', 'tab' => 'content'],
            ['name' => 's3_btn_text', 'type' => 'text', 'label' => __('Slide 3 - Button Text'), 'default' => __('Learn More'), 'tab' => 'content'],
            ['name' => 's3_btn_url', 'type' => 'text', 'label' => __('Slide 3 - Button URL'), 'default' => '/about', 'tab' => 'content'],

            // Global Style
            ['name' => 'overlay_color', 'type' => 'color', 'label' => __('Overlay Color'), 'default' => '#000000', 'tab' => 'style'],
            ['name' => 'overlay_opacity', 'type' => 'range', 'label' => __('Overlay Opacity (%)'), 'default' => 40, 'min' => 0, 'max' => 100, 'tab' => 'style'],
            ['name' => 'title_color', 'type' => 'color', 'label' => __('Title Color'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'subtitle_color', 'type' => 'color', 'label' => __('Subtitle Color'), 'default' => '#f3f4f6', 'tab' => 'style'],
            ['name' => 'btn_bg', 'type' => 'color', 'label' => __('Button Background'), 'default' => '#111827', 'tab' => 'style'],
            ['name' => 'btn_text_color', 'type' => 'color', 'label' => __('Button Text Color'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'btn_hover_bg', 'type' => 'color', 'label' => __('Button Hover Background'), 'default' => '#374151', 'tab' => 'style'],
            ['name' => 'btn_hover_text_color', 'type' => 'color', 'label' => __('Button Hover Text Color'), 'default' => '#ffffff', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $slides = [];

        for ($i = 1; $i <= 3; $i++) {
            if (!empty($settings['s'.$i.'_image'])) {
                $slides[] = [
                    'image' => $settings['s'.$i.'_image'],
                    'title' => $settings['s'.$i.'_title'] ?? '',
                    'subtitle' => $settings['s'.$i.'_subtitle'] ?? '',
                    'btn_text' => $settings['s'.$i.'_btn_text'] ?? '',
                    'btn_url' => $settings['s'.$i.'_btn_url'] ?? '',
                ];
            }
        }

        if (empty($slides)) {
            return '<div class="p-8 text-center text-gray-500 bg-gray-100 rounded-lg">' . __('Please add at least one slide image to display the slider.') . '</div>';
        }

        $uid = 'slider_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.hero-slide', compact('settings', 'slides', 'uid'))->render();
    }
}
