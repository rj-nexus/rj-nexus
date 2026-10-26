<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ButtonWidget extends BaseWidget
{
    public function id(): string
    {
        return 'button';
    }

    public function name(): string
    {
        return __('Button');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>';
    }

    public function category(): string
    {
        return 'basic';
    }

    public function description(): string
    {
        return __('Create highly customizable buttons with icons, animations, and various styles.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'text',
                'type' => 'text',
                'label' => __('Button Text'),
                'default' => __('Click Here'),
                'tab' => 'content',
            ],
            [
                'name' => 'url',
                'type' => 'text',
                'label' => __('Button URL'),
                'default' => '#',
                'tab' => 'content',
            ],
            [
                'name' => 'target',
                'type' => 'select',
                'label' => __('Target'),
                'default' => '_self',
                'tab' => 'content',
                'options' => [
                    '_self' => __('Same Window'),
                    '_blank' => __('New Window'),
                ]
            ],
            [
                'name' => 'icon',
                'type' => 'icon',
                'label' => __('Icon'),
                'default' => 'ph:arrow-right',
                'tab' => 'content',
            ],
            [
                'name' => 'icon_position',
                'type' => 'select',
                'label' => __('Icon Position'),
                'default' => 'right',
                'tab' => 'content',
                'options' => [
                    'left' => __('Left'),
                    'right' => __('Right'),
                ]
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Button Style'),
                'default' => 'solid',
                'tab' => 'style',
                'options' => [
                    'solid' => __('Solid'),
                    'outline' => __('Outline'),
                    'ghost' => __('Ghost (Transparent)'),
                    'gradient' => __('Gradient'),
                ]
            ],
            [
                'name' => 'size',
                'type' => 'select',
                'label' => __('Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                    'xl' => __('Extra Large'),
                ]
            ],
            [
                'name' => 'border_radius',
                'type' => 'select',
                'label' => __('Border Radius'),
                'default' => 'rounded-xl',
                'tab' => 'style',
                'options' => [
                    'rounded-none' => __('None'),
                    'rounded-md' => __('Small'),
                    'rounded-xl' => __('Medium'),
                    'rounded-full' => __('Full (Pill)'),
                ]
            ],
            [
                'name' => 'bg_color',
                'type' => 'color',
                'label' => __('Background Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'text_color',
                'type' => 'color',
                'label' => __('Text & Icon Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'hover_bg_color',
                'type' => 'color',
                'label' => __('Hover Background Color'),
                'default' => '#7c3aed',
                'tab' => 'style',
            ],
            [
                'name' => 'hover_text_color',
                'type' => 'color',
                'label' => __('Hover Text Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'animation',
                'type' => 'select',
                'label' => __('Hover Animation'),
                'default' => 'hover-lift',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'hover-lift' => __('Lift Up'),
                    'hover-glow' => __('Glow (Shadow)'),
                    'hover-shine' => __('Shine Effect'),
                    'hover-slide' => __('Icon Slide'),
                ]
            ],
            [
                'name' => 'full_width',
                'type' => 'toggle',
                'label' => __('Full Width'),
                'default' => false,
                'tab' => 'style',
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ]
            ]
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'btn_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.button', compact('settings', 'uid'))->render();
    }
}
