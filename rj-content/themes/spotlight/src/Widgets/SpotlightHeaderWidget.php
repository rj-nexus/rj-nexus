<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightHeaderWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-header';
    }

    public function name(): string
    {
        return __('Spotlight Header');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>';
    }

    public function category(): string
    {
        return 'header';
    }

    public function description(): string
    {
        return __('A transparent, glassmorphism header with sticky support, menu, language switcher, and CTA button.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'logo_text',
                'type' => 'text',
                'label' => __('Logo Text'),
                'default' => 'RJ CMS',
            ],
            [
                'name' => 'logo_image',
                'type' => 'media',
                'label' => __('Logo Image'),
                'default' => '',
            ],
            [
                'name' => 'menu_id',
                'type' => 'select',
                'label' => __('Select Menu'),
                'options' => rj_menu_options(),
                'default' => '',
            ],
            [
                'name' => 'show_language',
                'type' => 'toggle',
                'label' => __('Show Language Switcher'),
                'default' => true,
            ],
            [
                'name' => 'cta_text',
                'type' => 'text',
                'label' => __('CTA Button Text'),
                'default' => __('Get started'),
            ],
            [
                'name' => 'cta_url',
                'type' => 'text',
                'label' => __('CTA Button URL'),
                'default' => '/',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-header', compact('settings'))->render();
    }
}
