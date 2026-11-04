<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightLogosWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-logos';
    }

    public function name(): string
    {
        return __('Spotlight Logos / Trusted By');
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
        return __('A sleek, transparent section displaying client or partner logos with a grayscale hover effect.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title_text',
                'type' => 'text',
                'label' => __('Section Title'),
                'default' => 'Trusted by 6,000+ highly productive companies',
            ],
            [
                'name' => 'logo_1',
                'type' => 'text',
                'label' => __('Logo 1 URL'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-1.svg',
            ],
            [
                'name' => 'logo_2',
                'type' => 'text',
                'label' => __('Logo 2 URL'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-2.svg',
            ],
            [
                'name' => 'logo_3',
                'type' => 'text',
                'label' => __('Logo 3 URL'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-3.svg',
            ],
            [
                'name' => 'logo_4',
                'type' => 'text',
                'label' => __('Logo 4 URL'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-4.svg',
            ],
            [
                'name' => 'logo_5',
                'type' => 'text',
                'label' => __('Logo 5 URL'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-5.svg',
            ],
            [
                'name' => 'logo_6',
                'type' => 'text',
                'label' => __('Logo 6 URL'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-6.svg',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-logos', compact('settings'))->render();
    }
}
