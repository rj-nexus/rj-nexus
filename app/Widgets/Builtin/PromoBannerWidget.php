<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class PromoBannerWidget extends BaseWidget
{
    public function id(): string
    {
        return 'promo-banner';
    }

    public function name(): string
    {
        return __('Promo Banner');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89-3.79a2 2 0 011.79 0L21 8M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-3-4h6"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('An animated promotional banner with optional countdown, coupon code, image, and floating shapes.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'layout',
                'type'    => 'image_select',
                'label'   => __('Layout'),
                'default' => 'split',
                'tab'     => 'content',
                'options' => [
                    'split'    => ['label' => __('Split'), 'image' => 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 60"><rect width="120" height="60" rx="4" fill="%23f1f5f9"/><rect x="8" y="14" width="50" height="6" rx="2" fill="%238b5cf6"/><rect x="8" y="26" width="56" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="8" y="33" width="48" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="8" y="44" width="24" height="8" rx="3" fill="%238b5cf6"/><rect x="70" y="10" width="42" height="40" rx="4" fill="%23e2e8f0"/></svg>'],
                    'centered' => ['label' => __('Centered'), 'image' => 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 60"><rect width="120" height="60" rx="4" fill="%23f1f5f9"/><rect x="30" y="14" width="60" height="6" rx="2" fill="%238b5cf6"/><rect x="20" y="26" width="80" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="25" y="33" width="70" height="3" rx="1.5" fill="%23cbd5e1"/><rect x="45" y="44" width="30" height="8" rx="3" fill="%238b5cf6"/></svg>'],
                    'ribbon'   => ['label' => __('Ribbon'), 'image' => 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 60"><rect width="120" height="60" rx="4" fill="%23f1f5f9"/><rect y="22" width="120" height="16" fill="%238b5cf6"/><rect x="30" y="28" width="60" height="4" rx="2" fill="white"/></svg>'],
                ],
            ],
            [
                'name'    => 'badge',
                'type'    => 'text',
                'label'   => __('Badge Text'),
                'default' => __('LIMITED OFFER'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('Summer Sale'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'highlight',
                'type'    => 'text',
                'label'   => __('Highlighted Word'),
                'default' => __('50% OFF'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'desc',
                'type'    => 'textarea',
                'label'   => __('Description'),
                'default' => __('Grab the biggest deals of the season before they disappear.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn_label',
                'type'    => 'text',
                'label'   => __('Button Label'),
                'default' => __('Shop Now'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn_url',
                'type'    => 'text',
                'label'   => __('Button URL'),
                'default' => '#',
                'tab'     => 'content',
            ],
            [
                'name'    => 'image',
                'type'    => 'media',
                'label'   => __('Side Image'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'countdown',
                'type'    => 'toggle',
                'label'   => __('Show Countdown Timer'),
                'default' => false,
                'tab'     => 'content',
            ],
            [
                'name'    => 'countdown_end',
                'type'    => 'text',
                'label'   => __('Countdown End (YYYY-MM-DD HH:MM)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Example: 2026-12-31 23:59'),
            ],
            [
                'name'    => 'coupon',
                'type'    => 'text',
                'label'   => __('Coupon Code'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'coupon_hint',
                'type'    => 'text',
                'label'   => __('Coupon Hint'),
                'default' => __('Use code at checkout'),
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
                    'image'    => __('Image Background'),
                ],
            ],
            [
                'name'    => 'bg_image',
                'type'    => 'media',
                'label'   => __('Background Image'),
                'default' => '',
                'tab'     => 'style',
                'help'    => __('Used only for Image Background style.'),
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
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Corner Radius'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'xl'   => __('Large'),
                    '2xl'  => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'show_shapes',
                'type'    => 'toggle',
                'label'   => __('Show Floating Shapes'),
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
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 60,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'pb_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.promo-banner', compact('settings', 'uid'))->render();
    }
}
