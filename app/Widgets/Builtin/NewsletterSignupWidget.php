<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class NewsletterSignupWidget extends BaseWidget
{
    public function id(): string
    {
        return 'newsletter-signup';
    }

    public function name(): string
    {
        return __('Newsletter Signup');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6"/></svg>';
    }

    public function category(): string
    {
        return 'forms';
    }

    public function description(): string
    {
        return __('A newsletter signup form with inline, card and hero layouts, validation and rate limiting.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'card',
                'tab'     => 'content',
                'options' => [
                    'inline' => __('Inline (single line)'),
                    'card'   => __('Card'),
                    'hero'   => __('Hero (big)'),
                    'strip'  => __('Strip (banner)'),
                ],
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('Join our newsletter'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Subtitle'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'desc',
                'type'    => 'textarea',
                'label'   => __('Description'),
                'default' => __('Get the latest news, updates and special offers delivered to your inbox.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_name',
                'type'    => 'toggle',
                'label'   => __('Show Name Field'),
                'default' => false,
                'tab'     => 'content',
            ],
            [
                'name'    => 'name_placeholder',
                'type'    => 'text',
                'label'   => __('Name Placeholder'),
                'default' => __('Your name'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'email_placeholder',
                'type'    => 'text',
                'label'   => __('Email Placeholder'),
                'default' => __('Enter your email address'),
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
                'name'    => 'privacy_text',
                'type'    => 'text',
                'label'   => __('Privacy Checkbox Text'),
                'default' => __('I agree to receive emails and accept the privacy policy.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'privacy_required',
                'type'    => 'toggle',
                'label'   => __('Require Privacy Checkbox'),
                'default' => true,
                'tab'     => 'content',
                'help'    => __('GDPR: users must explicitly opt-in to receive emails.'),
            ],
            [
                'name'    => 'privacy_url',
                'type'    => 'text',
                'label'   => __('Privacy Policy URL'),
                'default' => '/privacy',
                'tab'     => 'content',
            ],
            [
                'name'    => 'success_message',
                'type'    => 'text',
                'label'   => __('Success Message'),
                'default' => __('Thanks! You are now subscribed.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_icon',
                'type'    => 'toggle',
                'label'   => __('Show Mail Icon'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_count',
                'type'    => 'toggle',
                'label'   => __('Show Subscriber Count'),
                'default' => false,
                'tab'     => 'style',
            ],
            [
                'name'    => 'count_label',
                'type'    => 'text',
                'label'   => __('Count Label'),
                'default' => __('Join :n subscribers'),
                'tab'     => 'style',
            ],
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Style'),
                'default' => 'gradient',
                'tab'     => 'style',
                'options' => [
                    'gradient' => __('Gradient'),
                    'solid'    => __('Solid'),
                    'dark'     => __('Dark'),
                    'light'    => __('Light'),
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
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Radius'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'xl'   => __('Extra Large'),
                    '2xl'  => __('Huge'),
                ],
            ],
            [
                'name'    => 'show_shapes',
                'type'    => 'toggle',
                'label'   => __('Show Decorative Shapes'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'center',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                ],
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
        $uid = 'nl_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.newsletter-signup', compact('settings', 'uid'))->render();
    }
}
