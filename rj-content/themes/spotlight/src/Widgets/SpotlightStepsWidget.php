<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightStepsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-steps';
    }

    public function name(): string
    {
        return __('Spotlight Steps / How to Use');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A split layout with a sticky changing visual on the left and scrollable steps on the right.');
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
                'default' => '[ 04 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ HOW TO USE ]',
            ],
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Top Badge Text'),
                'default' => '||| HOW TO USE QORE. |||',
            ],
            [
                'name' => 'bg_image_url',
                'type' => 'text',
                'label' => __('Background Arc Image URL'),
                'default' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/gradient-planet.webp',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'From idea to output — in just three simple steps.',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => 'Qore streamlines your creative workflow. No complex settings, just results.',
            ],
            [
                'name' => 'steps',
                'type' => 'repeater',
                'label' => __('Steps (Max 9)'),
                'max_items' => 9,
                'default' => [
                    [
                        'step_num' => '01',
                        'step_title' => 'Pick a goal',
                        'step_text' => 'Choose the type of content you want to create: a tagline, description, image, video idea, and more.',
                        'step_image_url' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/step1.png',
                    ],
                    [
                        'step_num' => '02',
                        'step_title' => 'Add a prompt',
                        'step_text' => 'Enter keywords, context, or any starting idea. Upload images or videos to guide the result.',
                        'step_image_url' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/step2.png',
                    ],
                    [
                        'step_num' => '03',
                        'step_title' => 'Get results',
                        'step_text' => 'Qore returns multiple outputs. Choose your favorite, refine it, or keep exploring more options.',
                        'step_image_url' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/step3.png',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'step_num',
                        'type' => 'text',
                        'label' => __('Step Number'),
                        'default' => '01',
                    ],
                    [
                        'name' => 'step_title',
                        'type' => 'text',
                        'label' => __('Step Title'),
                        'default' => 'Step Title',
                    ],
                    [
                        'name' => 'step_text',
                        'type' => 'textarea',
                        'label' => __('Step Description'),
                        'default' => 'Step description goes here.',
                    ],
                    [
                        'name' => 'step_image',
                        'type' => 'media',
                        'label' => __('Step Image (Local Upload)'),
                        'default' => '',
                    ],
                    [
                        'name' => 'step_image_url',
                        'type' => 'text',
                        'label' => __('Step Image (External URL)'),
                        'default' => '',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-steps', compact('settings'))->render();
    }
}
