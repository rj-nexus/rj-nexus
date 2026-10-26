<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class TestimonialWidget extends BaseWidget
{
    public function id(): string
    {
        return 'testimonial';
    }

    public function name(): string
    {
        return __('Testimonial');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Display customer reviews with images, ratings, and a modern layout.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'image',
                'type' => 'media',
                'label' => __('Customer Image'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'name',
                'type' => 'text',
                'label' => __('Customer Name'),
                'default' => __('Jane Doe'),
                'tab' => 'content',
            ],
            [
                'name' => 'position',
                'type' => 'text',
                'label' => __('Customer Position / Company'),
                'default' => __('CEO at TechCorp'),
                'tab' => 'content',
            ],
            [
                'name' => 'text',
                'type' => 'textarea',
                'label' => __('Review Text'),
                'default' => __('This is the best service I have ever used. The attention to detail and customer support is absolutely phenomenal. Highly recommended!'),
                'tab' => 'content',
            ],
            [
                'name' => 'rating',
                'type' => 'range',
                'label' => __('Rating (Stars)'),
                'default' => 5,
                'min' => 1,
                'max' => 5,
                'tab' => 'content',
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Design Style'),
                'default' => 'modern',
                'tab' => 'style',
                'options' => [
                    'modern' => __('Modern (White Card)'),
                    'minimal' => __('Minimal (No Background)'),
                    'glass' => __('Glassmorphism (Frosted)'),
                ],
            ],
            [
                'name' => 'star_color',
                'type' => 'color',
                'label' => __('Star Color'),
                'default' => '#f59e0b',
                'tab' => 'style',
            ],
            [
                'name' => 'quote_color',
                'type' => 'color',
                'label' => __('Quote Icon Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'image_style',
                'type' => 'select',
                'label' => __('Image Shape'),
                'default' => 'circle',
                'tab' => 'style',
                'options' => [
                    'circle' => __('Circle'),
                    'rounded' => __('Rounded Square'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'testi_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.testimonial', compact('settings', 'uid'))->render();
    }
}
