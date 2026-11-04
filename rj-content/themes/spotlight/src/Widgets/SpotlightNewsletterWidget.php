<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightNewsletterWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-newsletter';
    }

    public function name(): string
    {
        return __('Spotlight Newsletter');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A stunning dark-mode newsletter signup with glowing effects and AJAX submission.');
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
                'default' => '[ 09 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ NEWSLETTER ]',
            ],
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => '||| STAY IN THE LOOP. |||',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'Join the RJ Nexus newsletter.',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => 'Get the latest updates, exclusive content, and product news delivered straight to your inbox. No spam, ever.',
            ],
            [
                'name' => 'btn_text',
                'type' => 'text',
                'label' => __('Button Text'),
                'default' => 'Subscribe Now',
            ],
            [
                'name' => 'privacy_text',
                'type' => 'text',
                'label' => __('Privacy Checkbox Text'),
                'default' => 'I agree to receive emails and accept the privacy policy.',
            ],
            [
                'name' => 'privacy_required',
                'type' => 'toggle',
                'label' => __('Require Privacy Checkbox'),
                'default' => true,
            ],
            [
                'name' => 'glow_color',
                'type' => 'color',
                'label' => __('Glow Color'),
                'default' => '#3b82f6',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-newsletter', compact('settings'))->render();
    }
}
