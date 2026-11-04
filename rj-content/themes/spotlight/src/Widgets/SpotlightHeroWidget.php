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
        return __('A dark, modern hero section with a badge, gradient text, and dual CTA buttons.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => __('Now Live'),
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => __('Welcome to the Future'),
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => __('A modern, dark-first platform built to showcase your work with clarity and style.'),
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
