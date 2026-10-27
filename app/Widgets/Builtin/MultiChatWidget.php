<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class MultiChatWidget extends BaseWidget
{
    public function id(): string
    {
        return 'multi-chat';
    }

    public function name(): string
    {
        return __('Multi-Chat Button');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A floating action button that expands into multiple contact channels — WhatsApp, Telegram, Instagram, Email, Phone and many more.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'position',
                'type'    => 'select',
                'label'   => __('Position'),
                'default' => 'bottom-right',
                'tab'     => 'style',
                'options' => [
                    'bottom-right' => __('Bottom Right'),
                    'bottom-left'  => __('Bottom Left'),
                    'top-right'    => __('Top Right'),
                    'top-left'     => __('Top Left'),
                ],
            ],
            [
                'name'    => 'icon_style',
                'type'    => 'select',
                'label'   => __('Icon Style'),
                'default' => 'brand',
                'tab'     => 'style',
                'options' => [
                    'brand'  => __('Brand Colors'),
                    'mono'   => __('Monochrome'),
                    'custom' => __('Custom Accent'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Custom Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
                'help'    => __('Used only when Icon Style is "Custom Accent".'),
            ],
            [
                'name'    => 'size',
                'type'    => 'select',
                'label'   => __('Button Size'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'trigger',
                'type'    => 'select',
                'label'   => __('Open Trigger'),
                'default' => 'click',
                'tab'     => 'style',
                'options' => [
                    'click' => __('Click'),
                    'hover' => __('Hover'),
                ],
            ],
            [
                'name'    => 'main_label',
                'type'    => 'text',
                'label'   => __('Main Button Tooltip'),
                'default' => __('Contact us'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_labels',
                'type'    => 'toggle',
                'label'   => __('Show Channel Labels'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'badge',
                'type'    => 'text',
                'label'   => __('Notification Badge (e.g. "1")'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'pulse',
                'type'    => 'toggle',
                'label'   => __('Pulse Animation'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'greeting',
                'type'    => 'textarea',
                'label'   => __('Greeting Message (optional)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Shows as a small bubble next to the main button.'),
            ],
            [
                'name'    => 'greeting_delay',
                'type'    => 'range',
                'label'   => __('Greeting Delay (seconds)'),
                'default' => 3,
                'min'     => 0,
                'max'     => 30,
                'step'    => 1,
                'tab'     => 'content',
            ],
            [
                'name'    => 'channels',
                'type'    => 'repeater',
                'label'   => __('Contact Channels'),
                'tab'     => 'content',
                'fields' => [
                    ['name' => 'platform', 'type' => 'select', 'label' => __('Platform'), 'options' => [
                        'whatsapp'  => 'WhatsApp',
                        'telegram'  => 'Telegram',
                        'instagram' => 'Instagram',
                        'facebook'  => 'Facebook',
                        'messenger' => 'Messenger',
                        'twitter'   => 'X (Twitter)',
                        'tiktok'    => 'TikTok',
                        'linkedin'  => 'LinkedIn',
                        'youtube'   => 'YouTube',
                        'viber'     => 'Viber',
                        'skype'     => 'Skype',
                        'discord'   => 'Discord',
                        'signal'    => 'Signal',
                        'email'     => 'Email',
                        'phone'     => 'Phone Call',
                        'sms'       => 'SMS',
                        'website'   => 'Website',
                        'custom'    => 'Custom',
                    ]],
                    ['name' => 'value',    'type' => 'text', 'label' => __('Username / Number / URL')],
                    ['name' => 'label',    'type' => 'text', 'label' => __('Label (shown in tooltip)')],
                    ['name' => 'icon',     'type' => 'icon', 'label' => __('Custom Icon (optional)')],
                    ['name' => 'color',    'type' => 'text', 'label' => __('Color Override (hex, optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'mc_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.multi-chat', compact('settings', 'uid'))->render();
    }
}
