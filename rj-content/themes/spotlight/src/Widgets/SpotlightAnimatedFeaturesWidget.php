<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightAnimatedFeaturesWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-animated-features';
    }

    public function name(): string
    {
        return __('Spotlight Animated Features');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A futuristic features grid with an animated CSS quantum core visual on top.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Top Badge Text'),
                'default' => '||| WHY RJ NEXUS WORKS SMARTER. |||',
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
                    ['icon' => 'ph:device-mobile', 'feature_title' => 'All-in-one platform', 'feature_text' => 'No more juggling tools. We unify content, design, code, and video.'],
                    ['icon' => 'ph:cpu', 'feature_title' => 'Multi-model AI core', 'feature_text' => 'ChatGPT, Claude, Gemini — we pick the smartest engine for every task.'],
                    ['icon' => 'ph:desktop', 'feature_title' => 'Prompt-level control', 'feature_text' => 'Every feature is prompt-optimized, giving you control without overwhelm.'],
                    ['icon' => 'ph:rocket-launch', 'feature_title' => 'Speed that scales', 'feature_text' => 'From solo to teams, we deliver fast outputs — even under heavy loads.'],
                    ['icon' => 'ph:shield-check', 'feature_title' => 'Secure by design', 'feature_text' => 'Your content and code stay private. We never store sensitive data.'],
                    ['icon' => 'ph:arrows-clockwise', 'feature_title' => 'Always evolving', 'feature_text' => 'We improve weekly with better prompts, UI, and models — for free.'],
                ],
                'fields' => [
                    [
                        'name' => 'icon',
                        'type' => 'icon',
                        'label' => __('Icon (Iconify)'),
                        'default' => 'ph:sparkle',
                    ],
                    [
                        'name' => 'feature_title',
                        'type' => 'text',
                        'label' => __('Feature Title'),
                        'default' => 'Feature Name',
                    ],
                    [
                        'name' => 'feature_text',
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
        return view('theme::widgets.spotlight-animated-features', compact('settings'))->render();
    }
}
