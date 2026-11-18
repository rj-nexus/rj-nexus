<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightFooterWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-footer';
    }

    public function name(): string
    {
        return __('Spotlight Footer');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A structural, grid-based footer with dynamic CMS menus and brand identity.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'logo_image',
                'type' => 'media',
                'label' => __('Logo Image'),
                'default' => '',
            ],
            [
                'name' => 'logo_text',
                'type' => 'text',
                'label' => __('Logo Text'),
                'default' => 'RJ Nexus',
            ],
            [
                'name' => 'tagline',
                'type' => 'textarea',
                'label' => __('Tagline (Optional)'),
                'default' => '',
            ],
            [
                'name' => 'menu_1_id',
                'type' => 'select',
                'label' => __('Column 1 Menu'),
                'options' => rj_menu_options(),
                'default' => '',
            ],
            [
                'name' => 'menu_2_id',
                'type' => 'select',
                'label' => __('Column 2 Menu'),
                'options' => rj_menu_options(),
                'default' => '',
            ],
            [
                'name' => 'menu_3_id',
                'type' => 'select',
                'label' => __('Column 3 Menu'),
                'options' => rj_menu_options(),
                'default' => '',
            ],
            [
                'name' => 'show_copyright',
                'type' => 'toggle',
                'label' => __('Show Copyright Bar'),
                'default' => true,
            ],
            [
                'name' => 'copyright_text',
                'type' => 'text',
                'label' => __('Copyright Text'),
                'default' => '© ' . date('Y') . ' RJ NEXUS. ALL RIGHTS RESERVED.',
            ],
            [
                'name' => 'show_back_to_top',
                'type' => 'toggle',
                'label' => __('Show Back to Top Link'),
                'default' => true,
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-footer', compact('settings'))->render();
    }
}
