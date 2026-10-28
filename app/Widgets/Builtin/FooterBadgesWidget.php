<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FooterBadgesWidget extends BaseWidget
{
    public function id(): string
    {
        return 'footer-badges';
    }

    public function name(): string
    {
        return __('Footer Badges');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>';
    }

    public function category(): string
    {
        return 'footer';
    }

    public function description(): string
    {
        return __('Display payment methods, trust badges, or partner logos in the footer.');
    }

    public function contexts(): array
    {
        return ['footer'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title / Heading'),
                'default' => __('Secure Payment Options'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'left',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                    'right'  => __('Right'),
                ],
            ],
            [
                'name'    => 'gap',
                'type'    => 'select',
                'label'   => __('Item Spacing'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'height',
                'type'    => 'range',
                'label'   => __('Badge Height (px)'),
                'default' => 32,
                'min'     => 16,
                'max'     => 80,
                'step'    => 2,
                'tab'     => 'style',
            ],
            [
                'name'    => 'title_color',
                'type'    => 'color',
                'label'   => __('Title Color'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'grayscale',
                'type'    => 'toggle',
                'label'   => __('Grayscale by Default'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'items',
                'type'    => 'repeater',
                'label'   => __('Badges / Logos'),
                'tab'     => 'content',
                'fields'  => [
                    ['name' => 'image', 'type' => 'media', 'label' => __('Image (SVG/PNG)')],
                    ['name' => 'icon',  'type' => 'icon',  'label' => __('Or Iconify Icon')],
                    ['name' => 'name',  'type' => 'text',  'label' => __('Alt Text')],
                    ['name' => 'url',   'type' => 'text',  'label' => __('URL (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'fb_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.footer-badges', compact('settings', 'uid'))->render();
    }
}
