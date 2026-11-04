<?php

namespace VelvetAura\Widgets;

use App\Widgets\BaseWidget;

class HeroSliderWidget extends BaseWidget
{
    public function id(): string
    {
        return 'velvet-hero-slider';
    }

    public function name(): string
    {
        return __('Velvet Hero Slider');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'velvet-aura';
    }

    public function description(): string
    {
        return __('A full-width luxury hero slider with up to 3 slides, background images, titles, and CTA buttons.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Section Height'),
                'default' => 'min-h-[80vh]',
                'options' => [
                    'min-h-[60vh]' => __('Medium'),
                    'min-h-[80vh]' => __('Large'),
                    'min-h-screen' => __('Full Screen'),
                ],
            ],
            [
                'name' => 'autoplay_speed',
                'type' => 'number',
                'label' => __('Autoplay Speed (ms)'),
                'default' => 5000,
            ],
            [
                'name' => 's1_image',
                'type' => 'media',
                'label' => __('Slide 1 - Background Image'),
                'default' => '',
            ],
            [
                'name' => 's1_title',
                'type' => 'text',
                'label' => __('Slide 1 - Main Title'),
                'default' => __('The Cocktails Collection'),
            ],
            [
                'name' => 's1_subtitle',
                'type' => 'text',
                'label' => __('Slide 1 - Subtitle'),
                'default' => __('Perfumes inspired by the art of mixology'),
            ],
            [
                'name' => 's1_btn_text',
                'type' => 'text',
                'label' => __('Slide 1 - Button Text'),
                'default' => __('Discover The Collection'),
            ],
            [
                'name' => 's1_btn_url',
                'type' => 'text',
                'label' => __('Slide 1 - Button URL'),
                'default' => '/shop',
            ],
            [
                'name' => 's2_image',
                'type' => 'media',
                'label' => __('Slide 2 - Background Image'),
                'default' => '',
            ],
            [
                'name' => 's2_title',
                'type' => 'text',
                'label' => __('Slide 2 - Main Title'),
                'default' => '',
            ],
            [
                'name' => 's2_subtitle',
                'type' => 'text',
                'label' => __('Slide 2 - Subtitle'),
                'default' => '',
            ],
            [
                'name' => 's2_btn_text',
                'type' => 'text',
                'label' => __('Slide 2 - Button Text'),
                'default' => __('Explore Now'),
            ],
            [
                'name' => 's2_btn_url',
                'type' => 'text',
                'label' => __('Slide 2 - Button URL'),
                'default' => '/shop',
            ],
            [
                'name' => 's3_image',
                'type' => 'media',
                'label' => __('Slide 3 - Background Image'),
                'default' => '',
            ],
            [
                'name' => 's3_title',
                'type' => 'text',
                'label' => __('Slide 3 - Main Title'),
                'default' => '',
            ],
            [
                'name' => 's3_subtitle',
                'type' => 'text',
                'label' => __('Slide 3 - Subtitle'),
                'default' => '',
            ],
            [
                'name' => 's3_btn_text',
                'type' => 'text',
                'label' => __('Slide 3 - Button Text'),
                'default' => __('Shop Now'),
            ],
            [
                'name' => 's3_btn_url',
                'type' => 'text',
                'label' => __('Slide 3 - Button URL'),
                'default' => '/shop',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.hero-slider', compact('settings'))->render();
    }
}
