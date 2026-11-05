<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightFeaturesGridWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-features-grid';
    }

    public function name(): string
    {
        return __('Spotlight Features Grid');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A compact split layout with an animated core and glass feature cards.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => 'Why RJ Nexus works smarter.',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'Built for modern teams. Backed by cutting-edge AI.',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => 'RJ Nexus combines powerful AI models with a unified creative workspace — built for speed, clarity, and control.',
            ],
            [
                'name' => 'features',
                'type' => 'repeater',
                'label' => __('Features (Max 6)'),
                'max_items' => 6,
                'default' => [
                    [
                        'icon' => 'ph:device-mobile',
                        'title' => 'All-in-one platform',
                        'desc' => 'No more juggling tools. We unify content, design, code, and video.',
                    ],
                    [
                        'icon' => 'ph:cpu',
                        'title' => 'Multi-model AI core',
                        'desc' => 'ChatGPT, Claude, Gemini — we pick the smartest engine for every task.',
                    ],
                    [
                        'icon' => 'ph:desktop',
                        'title' => 'Prompt-level control',
                        'desc' => 'Every feature is prompt-optimized, giving you control without overwhelm.',
                    ],
                    [
                        'icon' => 'ph:rocket-launch',
                        'title' => 'Speed that scales',
                        'desc' => 'From solo to teams, we deliver fast outputs — even under heavy loads.',
                    ],
                    [
                        'icon' => 'ph:shield-check',
                        'title' => 'Secure by design',
                        'desc' => 'Your content and code stay private. We never store sensitive data.',
                    ],
                    [
                        'icon' => 'ph:arrows-clockwise',
                        'title' => 'Always evolving',
                        'desc' => 'We improve weekly with better prompts, UI, and models — for free.',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'icon',
                        'type' => 'text',
                        'label' => __('Icon (Iconify Name)'),
                        'default' => 'ph:sparkle',
                        'help' => 'e.g. ph:rocket-launch, ph:cpu.',
                        'help_link' => 'https://iconify.design/',
                        'help_link_text' => __('Browse Icons on Iconify →')
                    ],
                    [
                        'name' => 'title',
                        'type' => 'text',
                        'label' => __('Feature Title'),
                        'default' => 'Feature Name',
                    ],
                    [
                        'name' => 'desc',
                        'type' => 'textarea',
                        'label' => __('Feature Description'),
                        'default' => 'Feature description goes here.',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-features-grid', compact('settings'))->render();
    }
}
