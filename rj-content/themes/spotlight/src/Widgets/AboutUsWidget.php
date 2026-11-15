<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AboutUsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'about-us';
    }

    public function name(): string
    {
        return __('About Us Section');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Two-column section with text and an image. Choose image position (left or right).');
    }

    public function contexts(): array
    {
        return ['page', 'block'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('About Us'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'content',
                'type'    => 'textarea',
                'label'   => __('Description'),
                'default' => __('We are a dedicated team of professionals passionate about delivering high-quality solutions. Our mission is to create exceptional experiences for our clients through innovation and hard work.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'image',
                'type'    => 'image',
                'label'   => __('Image'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'image_position',
                'type'    => 'select',
                'label'   => __('Image Position'),
                'default' => 'right',
                'tab'     => 'layout',
                'options' => [
                    'left'  => __('Left Side'),
                    'right' => __('Right Side'),
                ],
            ],
            [
                'name'    => 'button_text',
                'type'    => 'text',
                'label'   => __('Button Text'),
                'default' => __('Learn More'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'button_url',
                'type'    => 'text',
                'label'   => __('Button URL'),
                'default' => '#',
                'tab'     => 'content',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'au_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.about-us', compact('settings', 'uid'))->render();
    }
}