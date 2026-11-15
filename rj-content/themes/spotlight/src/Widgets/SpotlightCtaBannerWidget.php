<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightCtaBannerWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-cta-banner';
    }

    public function name(): string
    {
        return __('Spotlight CTA Banner');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A full-width, high-impact call-to-action section with a glowing background and centered button.');
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
                'default' => __('Ready to launch your next big idea?'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'textarea',
                'label'   => __('Subtitle'),
                'default' => __('Join thousands of creators and businesses building the future with our platform.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'button_text',
                'type'    => 'text',
                'label'   => __('Button Text'),
                'default' => __('Get Started Now'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'button_url',
                'type'    => 'text',
                'label'   => __('Button URL'),
                'default' => '#',
                'tab'     => 'content',
            ],
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Background Style'),
                'default' => 'gradient',
                'tab'     => 'style',
                'options' => [
                    'gradient' => __('Gradient Glow'),
                    'dark'     => __('Solid Dark'),
                    'glass'    => __('Glassmorphism Card'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'cta_' . substr(md5(uniqid('', true)), 0, 8);

        return view('spotlight::widgets.cta-banner', compact('settings', 'uid'))->render();
    }
}