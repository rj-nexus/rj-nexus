<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class LogoWidget extends BaseWidget
{
    public function id(): string
    {
        return 'logo';
    }

    public function name(): string
    {
        return __('Logo');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'basic';
    }

    public function description(): string
    {
        return __('Display your site logo with a custom link and size.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'image',
                'type'    => 'media',
                'label'   => __('Logo Image'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'url',
                'type'    => 'text',
                'label'   => __('Link URL'),
                'default' => '/',
                'tab'     => 'content',
            ],
            [
                'name'    => 'alt',
                'type'    => 'text',
                'label'   => __('Alt Text (SEO)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'width',
                'type'    => 'range',
                'label'   => __('Width (px)'),
                'default' => 140,
                'min'     => 20,
                'max'     => 400,
                'step'    => 5,
                'tab'     => 'style',
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
                'name'    => 'hover_opacity',
                'type'    => 'toggle',
                'label'   => __('Fade on Hover'),
                'default' => true,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'logo_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.logo', compact('settings', 'uid'))->render();
    }
}
