<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightShowcaseWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-showcase';
    }

    public function name(): string
    {
        return __('Spotlight Showcase');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A centered text and image showcase with a glowing effect and glass hover overlay.');
    }

    public function schema(): array
    {
        return [
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
                'default' => '[ FEATURES ]',
            ],
            [
                'name' => 'show_hud',
                'type' => 'toggle',
                'label' => __('Show HUD and Lines'),
                'default' => true,
            ],
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => '||| SIX TOOLS. ONE AI CORE. ENDLESS POTENTIAL. |||',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'What You Can Do with RJ Nexus',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => 'From visuals to code, RJ Nexus gives you a full creative suite powered by the latest multi-model AI — all in one place.',
            ],
            [
                'name' => 'image',
                'type' => 'media',
                'label' => __('Showcase Image (Local Upload)'),
                'default' => '',
            ],
            [
                'name' => 'image_url',
                'type' => 'text',
                'label' => __('Showcase Image (External URL)'),
                'default' => '',
            ],
            [
                'name' => 'glow_color',
                'type' => 'color',
                'label' => __('Glow Color'),
                'default' => '#3f6fbe',
            ],
            [
                'name' => 'glow_opacity',
                'type' => 'number',
                'label' => __('Glow Opacity (0-100)'),
                'default' => 50,
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-showcase', compact('settings'))->render();
    }
}
