<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CookieNoticeWidget extends BaseWidget
{
    public function id(): string
    {
        return 'cookie-notice';
    }

    public function name(): string
    {
        return __('Cookie Notice');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><circle cx="9" cy="10" r="1" fill="currentColor"/><circle cx="15" cy="10" r="1" fill="currentColor"/><circle cx="12" cy="15" r="1" fill="currentColor"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A GDPR-compliant cookie consent banner with accept, reject and settings panel.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'position',
                'type'    => 'select',
                'label'   => __('Position'),
                'default' => 'bottom',
                'tab'     => 'content',
                'options' => [
                    'bottom'       => __('Bottom (full-width bar)'),
                    'bottom-left'  => __('Bottom Left Card'),
                    'bottom-right' => __('Bottom Right Card'),
                    'center'       => __('Center Modal'),
                    'top'          => __('Top Bar'),
                ],
            ],
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Style'),
                'default' => 'card',
                'tab'     => 'style',
                'options' => [
                    'card'    => __('Card (solid white)'),
                    'dark'    => __('Dark'),
                    'glass'   => __('Glass (blur)'),
                    'minimal' => __('Minimal (no shadow)'),
                ],
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('We value your privacy'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'message',
                'type'    => 'textarea',
                'label'   => __('Message'),
                'default' => __('We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'privacy_url',
                'type'    => 'text',
                'label'   => __('Privacy Policy URL'),
                'default' => '/privacy',
                'tab'     => 'content',
            ],
            [
                'name'    => 'privacy_label',
                'type'    => 'text',
                'label'   => __('Privacy Link Text'),
                'default' => __('Privacy Policy'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'accept_label',
                'type'    => 'text',
                'label'   => __('Accept Button Label'),
                'default' => __('Accept All'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'reject_label',
                'type'    => 'text',
                'label'   => __('Reject Button Label'),
                'default' => __('Reject All'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'settings_label',
                'type'    => 'text',
                'label'   => __('Customize Button Label'),
                'default' => __('Customize'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_settings',
                'type'    => 'toggle',
                'label'   => __('Show "Customize" Button'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_reject',
                'type'    => 'toggle',
                'label'   => __('Show "Reject" Button'),
                'default' => true,
                'tab'     => 'content',
                'help'    => __('GDPR requires a reject option to be as prominent as accept.'),
            ],
            [
                'name'    => 'show_icon',
                'type'    => 'toggle',
                'label'   => __('Show Cookie Icon'),
                'default' => true,
                'tab'     => 'style',
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
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'muted_color',
                'type'    => 'color',
                'label'   => __('Muted Text Color'),
                'default' => '#64748b',
                'tab'     => 'style',
            ],
            [
                'name'    => 'bg_color',
                'type'    => 'color',
                'label'   => __('Background Color'),
                'default' => '#ffffff',
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
                'name'    => 'expire_days',
                'type'    => 'number',
                'label'   => __('Remember Choice (days)'),
                'default' => 365,
                'min'     => 1,
                'max'     => 730,
                'step'    => 1,
                'tab'     => 'content',
            ],
            [
                'name'    => 'enable_categories',
                'type'    => 'toggle',
                'label'   => __('Enable Cookie Categories'),
                'default' => true,
                'tab'     => 'content',
                'help'    => __('Shows detailed cookie categories in the settings panel.'),
            ],
            [
                'name'    => 'cat_necessary_label',
                'type'    => 'text',
                'label'   => __('Necessary Category Label'),
                'default' => __('Necessary'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'cat_necessary_desc',
                'type'    => 'text',
                'label'   => __('Necessary Category Description'),
                'default' => __('Required for the website to function. Cannot be disabled.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'cat_analytics_label',
                'type'    => 'text',
                'label'   => __('Analytics Category Label'),
                'default' => __('Analytics'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'cat_analytics_desc',
                'type'    => 'text',
                'label'   => __('Analytics Category Description'),
                'default' => __('Help us understand how visitors interact with the website.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'cat_marketing_label',
                'type'    => 'text',
                'label'   => __('Marketing Category Label'),
                'default' => __('Marketing'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'cat_marketing_desc',
                'type'    => 'text',
                'label'   => __('Marketing Category Description'),
                'default' => __('Used to deliver personalized ads and track campaign performance.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'cat_preferences_label',
                'type'    => 'text',
                'label'   => __('Preferences Category Label'),
                'default' => __('Preferences'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'cat_preferences_desc',
                'type'    => 'text',
                'label'   => __('Preferences Category Description'),
                'default' => __('Remember your settings such as language and theme.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'save_label',
                'type'    => 'text',
                'label'   => __('Save Preferences Label'),
                'default' => __('Save Preferences'),
                'tab'     => 'content',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'cn_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.cookie-notice', compact('settings', 'uid'))->render();
    }
}
