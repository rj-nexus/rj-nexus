<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FooterNewsletterWidget extends BaseWidget
{
    public function id(): string
    {
        return 'footer-newsletter';
    }

    public function name(): string
    {
        return __('Footer Newsletter');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'footer';
    }

    public function description(): string
    {
        return __('A compact newsletter subscription form designed for the footer area.');
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
                'label'   => __('Title'),
                'default' => __('Subscribe to our newsletter'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Subtitle'),
                'default' => __('Get the latest updates directly in your inbox.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'placeholder',
                'type'    => 'text',
                'label'   => __('Input Placeholder'),
                'default' => __('Enter your email'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn_label',
                'type'    => 'text',
                'label'   => __('Button Label'),
                'default' => __('Subscribe'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'success_msg',
                'type'    => 'text',
                'label'   => __('Success Message'),
                'default' => __('Thanks for subscribing!'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'inline',
                'tab'     => 'style',
                'options' => [
                    'inline'  => __('Inline (Input + Button)'),
                    'stacked' => __('Stacked (Input above Button)'),
                ],
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
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'muted_color',
                'type'    => 'color',
                'label'   => __('Muted Text Color'),
                'default' => '#94a3b8',
                'tab'     => 'style',
            ],
            [
                'name'    => 'input_bg',
                'type'    => 'color',
                'label'   => __('Input Background'),
                'default' => '#1e293b',
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Radius'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'sm'   => __('Small'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'full' => __('Full (Pill)'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'fn_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.footer-newsletter', compact('settings', 'uid'))->render();
    }
}
