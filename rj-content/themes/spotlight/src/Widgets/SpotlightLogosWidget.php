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
        return __('A transparent, always-white partner logo strip with an infinite marquee, HUD labels and hover glow.');
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
                'name' => 'logos',
                'type' => 'textarea',
                'label' => __('Logos (one per line: URL or URL | Name)'),
                'default' => "https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-1.svg | Logoipsum 1\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-2.svg | Logoipsum 2\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-3.svg | Logoipsum 3\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-4.svg | Logoipsum 4\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-5.svg | Logoipsum 5\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-6.svg | Logoipsum 6",
                'help' => __('GitHub raw/blob links are converted to jsDelivr automatically. Logos are always rendered white.'),
            ],
            [
                'name' => 'marquee',
                'type' => 'toggle',
                'label' => __('Infinite Scroll (Marquee)'),
                'default' => true,
            ],
            [
                'name' => 'speed',
                'type' => 'number',
                'label' => __('Marquee Loop Duration (seconds)'),
                'default' => 40,
            ],
            [
                'name' => 'show_hud',
                'type' => 'toggle',
                'label' => __('Show HUD Labels'),
                'default' => true,
            ],
            [
                'name' => 'hud_left',
                'type' => 'text',
                'label' => __('HUD Left Text'),
                'default' => '[ 02 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ PARTNERS ]',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-logos', compact('settings'))->render();
    }
}
