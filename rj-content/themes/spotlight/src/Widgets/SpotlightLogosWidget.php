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
                'name' => 'show_hud',
                'type' => 'toggle',
                'label' => __('Show HUD and Lines'),
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
            [
                'name' => 'title_text',
                'type' => 'text',
                'label' => __('Section Title'),
                'default' => 'Trusted by 6,000+ highly productive companies',
            ],
            [
                'name' => 'logos',
                'type' => 'textarea',
                'label' => __('Logo URLs (one per line)'),
                'default' => "https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-1.svg\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-2.svg\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-3.svg\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-4.svg\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-5.svg\nhttps://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/logos/logoipsum-6.svg",
                'help' => __('Paste image URLs here. Each line will be treated as a separate logo. You can also add a name separated by "|" (e.g. url.com/logo.svg | Company Name).'),
            ],
            [
                'name' => 'marquee',
                'type' => 'toggle',
                'label' => __('Enable Marquee (Scrolling)'),
                'default' => true,
            ],
            [
                'name' => 'speed',
                'type' => 'number',
                'label' => __('Marquee Speed (seconds)'),
                'default' => 40,
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-logos', compact('settings'))->render();
    }
}
