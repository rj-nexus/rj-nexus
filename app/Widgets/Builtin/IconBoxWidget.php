<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class IconBoxWidget extends BaseWidget
{
    public function id(): string
    {
        return 'icon-box';
    }

    public function name(): string
    {
        return __('Icon Box');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A card with an icon, title, and description with interactive hover animations.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'icon',
                'type' => 'icon',
                'label' => __('Icon'),
                'default' => 'ph:rocket-launch-fill',
                'tab' => 'content',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title'),
                'default' => __('Awesome Feature'),
                'tab' => 'content',
            ],
            [
                'name' => 'description',
                'type' => 'textarea',
                'label' => __('Description'),
                'default' => __('Explain why this feature is so great and how it benefits your users.'),
                'tab' => 'content',
            ],
            [
                'name' => 'link_url',
                'type' => 'text',
                'label' => __('Link URL (Optional)'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'layout',
                'type' => 'select',
                'label' => __('Layout'),
                'default' => 'top',
                'tab' => 'style',
                'options' => [
                    'top' => __('Icon Top, Text Bottom'),
                    'left' => __('Icon Left, Text Right'),
                    'right' => __('Text Left, Icon Right'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Text Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'icon_style',
                'type' => 'select',
                'label' => __('Icon Container Style'),
                'default' => 'circle',
                'tab' => 'style',
                'options' => [
                    'circle' => __('Circle Background'),
                    'square' => __('Square Background'),
                    'none' => __('Transparent (No Background)'),
                ],
            ],
            [
                'name' => 'icon_color',
                'type' => 'color',
                'label' => __('Icon Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'icon_bg',
                'type' => 'color',
                'label' => __('Icon Background Color'),
                'default' => '#8b5cf615',
                'tab' => 'style',
            ],
            [
                'name' => 'hover_animation',
                'type' => 'select',
                'label' => __('Icon Hover Animation'),
                'default' => 'rotate',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'rotate' => __('Rotate & Scale'),
                    'bounce' => __('Bounce'),
                    'float' => __('Float Up & Down'),
                    'pulse' => __('Pulse Glow'),
                ],
            ],
            [
                'name' => 'box_style',
                'type' => 'select',
                'label' => __('Box Style'),
                'default' => 'card',
                'tab' => 'style',
                'options' => [
                    'card' => __('Card (Shadow & Background)'),
                    'minimal' => __('Minimal (No Background)'),
                ],
            ],
            [
                'name' => 'border_radius',
                'type' => 'select',
                'label' => __('Box Border Radius'),
                'default' => 'rounded-2xl',
                'tab' => 'style',
                'options' => [
                    'rounded-none' => __('None'),
                    'rounded-xl' => __('Small'),
                    'rounded-2xl' => __('Medium'),
                    'rounded-3xl' => __('Large'),
                ],
            ],
                        [
                'name' => 'max_width',
                'type' => 'select',
                'label' => __('Card Max Width'),
                'default' => '420',
                'tab' => 'style',
                'options' => [
                    '320' => __('Narrow (320px)'),
                    '420' => __('Medium (420px)'),
                    '560' => __('Wide (560px)'),
                    '720' => __('Extra Wide (720px)'),
                    '1600' => __('Full Width'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'iconbox_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.icon-box', compact('settings', 'uid'))->render();
    }
}
