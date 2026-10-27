<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CallToActionWidget extends BaseWidget
{
    public function id(): string
    {
        return 'cta';
    }

    public function name(): string
    {
        return __('Call to Action');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A high-converting CTA block with gradient, decorative shapes, badge, dual buttons and feature chips.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'layout',
                'type'    => 'image_select',
                'label'   => __('Layout'),
                'default' => 'centered',
                'tab'     => 'content',
                'options' => [
                    'centered' => ['label' => __('Centered'), 'image' => 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 60"><rect width="120" height="60" rx="4" fill="%23f1f5f9"/><rect x="30" y="18" width="60" height="6" rx="2" fill="%238b5cf6"/><rect x="20" y="30" width="80" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="25" y="37" width="70" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="45" y="46" width="30" height="8" rx="3" fill="%238b5cf6"/></svg>'],
                    'split'    => ['label' => __('Split'), 'image' => 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 60"><rect width="120" height="60" rx="4" fill="%23f1f5f9"/><rect x="8" y="14" width="40" height="6" rx="2" fill="%238b5cf6"/><rect x="8" y="26" width="52" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="8" y="33" width="48" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="8" y="44" width="24" height="8" rx="3" fill="%238b5cf6"/><rect x="72" y="12" width="40" height="36" rx="4" fill="%23e2e8f0"/></svg>'],
                ],
            ],
            [
                'name'    => 'badge',
                'type'    => 'text',
                'label'   => __('Badge Text'),
                'default' => __('Limited Time Offer'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('Ready to grow your business?'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'highlight',
                'type'    => 'text',
                'label'   => __('Highlighted Word (in title)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('If this word exists in the title, it will get the accent gradient.'),
            ],
            [
                'name'    => 'desc',
                'type'    => 'textarea',
                'label'   => __('Description'),
                'default' => __('Join thousands of businesses already using our platform to increase sales and improve customer experience.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn1_label',
                'type'    => 'text',
                'label'   => __('Primary Button Label'),
                'default' => __('Get Started Free'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn1_url',
                'type'    => 'text',
                'label'   => __('Primary Button URL'),
                'default' => '#',
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn2_label',
                'type'    => 'text',
                'label'   => __('Secondary Button Label'),
                'default' => __('Book a Demo'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn2_url',
                'type'    => 'text',
                'label'   => __('Secondary Button URL'),
                'default' => '#',
                'tab'     => 'content',
            ],
            [
                'name'    => 'image',
                'type'    => 'media',
                'label'   => __('Side Image (split layout)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'chips',
                'type'    => 'textarea',
                'label'   => __('Feature Chips (one per line)'),
                'default' => "No credit card required\n14-day free trial\nCancel anytime",
                'tab'     => 'content',
            ],
            [
                'name'    => 'bg_style',
                'type'    => 'select',
                'label'   => __('Background Style'),
                'default' => 'gradient',
                'tab'     => 'style',
                'options' => [
                    'gradient' => __('Gradient'),
                    'solid'    => __('Solid Color'),
                    'dark'     => __('Dark'),
                    'glass'    => __('Glass'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Start'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent2',
                'type'    => 'color',
                'label'   => __('Accent End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'title_color',
                'type'    => 'color',
                'label'   => __('Title Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Description Color'),
                'default' => '#475569',
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'md'  => __('Medium'),
                    'xl'  => __('Large'),
                    '2xl' => __('Extra Large'),
                    '3xl' => __('Huge'),
                ],
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 80,
                'min'     => 40,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_shapes',
                'type'    => 'toggle',
                'label'   => __('Show Decorative Shapes'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'animate',
                'type'    => 'toggle',
                'label'   => __('Animate on Scroll'),
                'default' => true,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'cta_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.cta', compact('settings', 'uid'))->render();
    }
}
