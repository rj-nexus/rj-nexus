<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FooterCopyrightWidget extends BaseWidget
{
    public function id(): string
    {
        return 'footer-copyright';
    }

    public function name(): string
    {
        return __('Footer Copyright');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'footer';
    }

    public function description(): string
    {
        return __('A copyright line with dynamic year and optional privacy links.');
    }

    public function contexts(): array
    {
        return ['footer'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'text',
                'type'    => 'text',
                'label'   => __('Copyright Text'),
                'default' => __('© :year :site_name. All rights reserved.'),
                'tab'     => 'content',
                'help'    => __('Use :year for the current year and :site_name for the site name.'),
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
                    'right'  => __('Right'),
                ],
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#94a3b8',
                'tab'     => 'style',
            ],
            [
                'name'    => 'links',
                'type'    => 'repeater',
                'label'   => __('Footer Links'),
                'tab'     => 'content',
                'fields'  => [
                    ['name' => 'label', 'type' => 'text', 'label' => __('Label')],
                    ['name' => 'url',   'type' => 'text', 'label' => __('URL')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'fc_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.footer-copyright', compact('settings', 'uid'))->render();
    }
}
