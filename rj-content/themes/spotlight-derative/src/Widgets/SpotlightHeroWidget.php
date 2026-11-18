<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightHeroWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-hero';
    }

    public function name(): string
    {
        return __('Spotlight Hero');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A cinematic, full-screen hero with a blue-graded background video, fixed top label and rotating animated headline.');
    }

    public function schema(): array
    {
        return [
            // ---- Background ----
            [
                'name' => 'bg_video',
                'type' => 'media',
                'label' => __('Background Video (Local Upload)'),
                'default' => '',
            ],
            [
                'name' => 'bg_video_url',
                'type' => 'text',
                'label' => __('Background Video (External URL)'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4',
            ],
            [
                'name' => 'bg_image',
                'type' => 'media',
                'label' => __('Poster / Fallback Image (Local Upload)'),
                'default' => '',
            ],
            [
                'name' => 'bg_image_url',
                'type' => 'text',
                'label' => __('Poster / Fallback Image (External URL)'),
                'default' => '',
            ],

            // ---- Color grading ----
            [
                'name' => 'tint_color',
                'type' => 'color',
                'label' => __('Video Tint Color'),
                'default' => '#3f6fbe',
                'help' => __('Any video is converted to monochrome and tinted with this color.'),
            ],
            [
                'name' => 'tint_strength',
                'type' => 'number',
                'label' => __('Tint Strength (0-100)'),
                'default' => 100,
            ],
            [
                'name' => 'overlay_opacity',
                'type' => 'number',
                'label' => __('Darkness (0-100)'),
                'default' => 35,
            ],

            // ---- HUD ----
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
                'default' => '[ 01 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ HERO ]',
            ],
            [
                'name' => 'show_top_btn',
                'type' => 'toggle',
                'label' => __('Show Back-to-Top Button'),
                'default' => true,
            ],

            // ---- Fixed text ----
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Fixed Top Text'),
                'default' => __('Your All-In-One AI Creation Platform'),
            ],

            // ---- Rotating text ----
            [
                'name' => 'texts',
                'type' => 'textarea',
                'label' => __('Rotating Text (one per line: Title | Subtitle)'),
                'default' => "Create Smarter. Launch Faster. Built on ✦ Gemini | Design, generate, and build anything with a multi-model AI engine — one platform, endless possibilities.\nFrom Idea to Launch. In Minutes. | Describe what you need and let the engine draft, design and ship it for you.\nOne Platform. Every Model. | Switch between models without switching tools.",
                'help' => __('Each line is one screen. Use "|" to separate title and subtitle. Type ✦ for the sparkle icon.'),
            ],
            [
                'name' => 'interval',
                'type' => 'number',
                'label' => __('Seconds Between Changes'),
                'default' => 5,
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-hero', compact('settings'))->render();
    }
}
