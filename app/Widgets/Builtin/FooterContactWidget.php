<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FooterContactWidget extends BaseWidget
{
    public function id(): string
    {
        return 'footer-contact';
    }

    public function name(): string
    {
        return __('Footer Contact Info');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>';
    }

    public function category(): string
    {
        return 'footer';
    }

    public function description(): string
    {
        return __('A footer-specific contact information block with icons, labels and values.');
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
                'label'   => __('Title / Heading'),
                'default' => __('Contact Us'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'vertical',
                'tab'     => 'style',
                'options' => [
                    'vertical'   => __('Vertical List'),
                    'horizontal' => __('Horizontal Row'),
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
                'name'    => 'gap',
                'type'    => 'select',
                'label'   => __('Item Spacing'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
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
                'name'    => 'icon_color',
                'type'    => 'color',
                'label'   => __('Icon Color'),
                'default' => '#8b5cf6',
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
                'name'    => 'items',
                'type'    => 'repeater',
                'label'   => __('Contact Items'),
                'tab'     => 'content',
                'fields'  => [
                    ['name' => 'icon',  'type' => 'icon', 'label' => __('Icon')],
                    ['name' => 'label', 'type' => 'text', 'label' => __('Label (optional)')],
                    ['name' => 'value', 'type' => 'text', 'label' => __('Value')],
                    ['name' => 'url',   'type' => 'text', 'label' => __('URL (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'fct_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.footer-contact', compact('settings', 'uid'))->render();
    }
}
