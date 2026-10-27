<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ContactInfoWidget extends BaseWidget
{
    public function id(): string
    {
        return 'contact-info';
    }

    public function name(): string
    {
        return __('Contact Info Cards');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Contact information cards — address, phone, email, hours and social links with icons.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Get in touch'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'desc',
                'type'    => 'textarea',
                'label'   => __('Section Description'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'cards',
                'tab'     => 'style',
                'options' => [
                    'cards'   => __('Vertical Cards'),
                    'rows'    => __('Horizontal Rows'),
                    'icon-left'=> __('Icon + Text (minimal)'),
                ],
            ],
            [
                'name'    => 'columns',
                'type'    => 'select',
                'label'   => __('Columns'),
                'default' => '3',
                'tab'     => 'style',
                'options' => [
                    '1' => __('1 Column'),
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                ],
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Content Alignment'),
                'default' => 'center',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                ],
            ],
            [
                'name'    => 'card_style',
                'type'    => 'select',
                'label'   => __('Card Style'),
                'default' => 'card',
                'tab'     => 'style',
                'options' => [
                    'card'     => __('Card (shadow)'),
                    'bordered' => __('Bordered'),
                    'minimal'  => __('Minimal (no bg)'),
                    'gradient' => __('Gradient'),
                    'glass'    => __('Glass'),
                ],
            ],
            [
                'name'    => 'icon_style',
                'type'    => 'select',
                'label'   => __('Icon Style'),
                'default' => 'rounded',
                'tab'     => 'style',
                'options' => [
                    'circle'  => __('Circle'),
                    'rounded' => __('Rounded Square'),
                    'square'  => __('Square'),
                    'soft'    => __('Soft (tinted)'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent2',
                'type'    => 'color',
                'label'   => __('Gradient End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Title Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'muted_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#64748b',
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Corner Radius'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'xl'   => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'show_footer_cta',
                'type'    => 'toggle',
                'label'   => __('Show Footer CTA'),
                'default' => false,
                'tab'     => 'content',
            ],
            [
                'name'    => 'footer_label',
                'type'    => 'text',
                'label'   => __('Footer Button Label'),
                'default' => __('Contact Us'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'footer_url',
                'type'    => 'text',
                'label'   => __('Footer Button URL'),
                'default' => '/contact',
                'tab'     => 'content',
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
            [
                'name'    => 'cards',
                'type'    => 'repeater',
                'label'   => __('Contact Cards'),
                'tab'     => 'content',
                'fields' => [
                    ['name' => 'type',    'type' => 'select', 'label' => __('Type'), 'options' => [
                        'address' => __('Address'),
                        'phone'   => __('Phone'),
                        'email'   => __('Email'),
                        'hours'   => __('Business Hours'),
                        'whatsapp'=> __('WhatsApp'),
                        'telegram'=> __('Telegram'),
                        'website' => __('Website'),
                        'custom'  => __('Custom'),
                    ]],
                    ['name' => 'title',   'type' => 'text',     'label' => __('Title')],
                    ['name' => 'value',   'type' => 'text',     'label' => __('Primary Value (shown in bold)')],
                    ['name' => 'desc',    'type' => 'textarea', 'label' => __('Description')],
                    ['name' => 'link',    'type' => 'text',     'label' => __('Link URL (optional)')],
                    ['name' => 'icon',    'type' => 'icon',     'label' => __('Custom Icon (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'ci_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.contact-info', compact('settings', 'uid'))->render();
    }
}
