<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightHeroWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-hero';
    }

    public function name(): string
    {
        return __('Spotlight Hero');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A cinematic, full-screen hero section with background video/image support, large typography, and dual CTAs.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'bg_video',
                'type' => 'media',
                'label' => __('Background Video (MP4)'),
                'default' => '',
            ],
            [
                'name' => 'bg_image',
                'type' => 'media',
                'label' => __('Background Image (Fallback)'),
                'default' => '',
            ],
            [
                'name' => 'overlay_opacity',
                'type' => 'number',
                'label' => __('Overlay Opacity (0-100)'),
                'default' => 60,
            ],
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => __('Your All-In-One AI Creation Platform'),
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => __('Create Smarter. Launch Faster.'),
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => __('Design, generate, and build anything with a multi-model AI engine — one platform, endless possibilities.'),
            ],
            [
                'name' => 'primary_btn_text',
                'type' => 'text',
                'label' => __('Primary Button Text'),
                'default' => __('Get Started'),
            ],
            [
                'name' => 'primary_btn_url',
                'type' => 'text',
                'label' => __('Primary Button URL'),
                'default' => '/',
            ],
            [
                'name' => 'secondary_btn_text',
                'type' => 'text',
                'label' => __('Secondary Button Text'),
                'default' => __('Learn More'),
            ],
            [
                'name' => 'secondary_btn_url',
                'type' => 'text',
                'label' => __('Secondary Button URL'),
                'default' => '#features',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-hero', compact('settings'))->render();
    }
}
