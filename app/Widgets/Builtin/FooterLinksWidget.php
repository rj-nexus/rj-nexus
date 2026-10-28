<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FooterLinksWidget extends BaseWidget
{
    public function id(): string
    {
        return 'footer-links';
    }

    public function name(): string
    {
        return __('Footer Links');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
    }

    public function category(): string
    {
        return 'footer';
    }

    public function description(): string
    {
        return __('A footer-specific link block with a heading and vertical or horizontal list.');
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
                'default' => __('Quick Links'),
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
                'label'   => __('Link Spacing'),
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
                'name'    => 'link_color',
                'type'    => 'color',
                'label'   => __('Link Color'),
                'default' => '#94a3b8',
                'tab'     => 'style',
            ],
            [
                'name'    => 'hover_color',
                'type'    => 'color',
                'label'   => __('Link Hover Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'links',
                'type'    => 'repeater',
                'label'   => __('Links'),
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
        $uid = 'fl_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.footer-links', compact('settings', 'uid'))->render();
    }
}
