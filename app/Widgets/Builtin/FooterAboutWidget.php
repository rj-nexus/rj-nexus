<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FooterAboutWidget extends BaseWidget
{
    public function id(): string
    {
        return 'footer-about';
    }

    public function name(): string
    {
        return __('Footer About');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'footer';
    }

    public function description(): string
    {
        return __('A footer block with logo, title, description and optional social links.');
    }

    public function contexts(): array
    {
        return ['footer'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'logo',
                'type'    => 'media',
                'label'   => __('Logo'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'logo_width',
                'type'    => 'range',
                'label'   => __('Logo Width (px)'),
                'default' => 140,
                'min'     => 40,
                'max'     => 300,
                'step'    => 5,
                'tab'     => 'style',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('About Us'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'description',
                'type'    => 'textarea',
                'label'   => __('Description'),
                'default' => __('We are a creative agency dedicated to building beautiful and functional digital experiences.'),
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
                'name'    => 'title_color',
                'type'    => 'color',
                'label'   => __('Title Color'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#94a3b8',
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_socials',
                'type'    => 'toggle',
                'label'   => __('Show Social Links'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'socials',
                'type'    => 'repeater',
                'label'   => __('Social Links'),
                'tab'     => 'content',
                'fields'  => [
                    ['name' => 'platform', 'type' => 'select', 'label' => __('Platform'), 'options' => [
                        'facebook'  => 'Facebook',
                        'twitter'   => 'Twitter / X',
                        'instagram' => 'Instagram',
                        'linkedin'  => 'LinkedIn',
                        'youtube'   => 'YouTube',
                        'tiktok'    => 'TikTok',
                        'github'    => 'GitHub',
                    ]],
                    ['name' => 'url', 'type' => 'text', 'label' => __('URL')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'fa_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.footer-about', compact('settings', 'uid'))->render();
    }
}
