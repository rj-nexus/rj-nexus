<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightFeaturesWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-features';
    }

    public function name(): string
    {
        return __('Spotlight Features');
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
        return __('A features grid with top custom visual area, title, subtitle, and up to 9 icon cards.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'top_custom_code',
                'type' => 'textarea',
                'label' => __('Top Custom Visual (HTML/JSON)'),
                'default' => '',
                'help' => __('Paste custom HTML, SVG or animation code here. Leave empty for default abstract visual.'),
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
                'default' => 'Qore combines powerful AI models with a unified creative workspace — built for speed, clarity, and control.',
            ],
            [
                'name' => 'features',
                'type' => 'repeater',
                'label' => __('Features (Max 9)'),
                'max_items' => 9,
                'default' => [
                    ['icon' => 'ph:device-mobile', 'feature_title' => 'All-in-one platform', 'feature_text' => 'No more juggling tools. Qore unifies content, design, code, and video.'],
                    ['icon' => 'ph:cpu', 'feature_title' => 'Multi-model AI core', 'feature_text' => 'ChatGPT, Claude, Gemini — Qore picks the smartest engine for every task.'],
                    ['icon' => 'ph:desktop', 'feature_title' => 'Prompt-level control', 'feature_text' => 'Every feature is prompt-optimized, giving you control without overwhelm.'],
                    ['icon' => 'ph:rocket-launch', 'feature_title' => 'Speed that scales', 'feature_text' => 'From solo to teams, Qore delivers fast outputs — even under heavy loads.'],
                    ['icon' => 'ph:shield-check', 'feature_title' => 'Secure by design', 'feature_text' => 'Your content and code stay private. We never store sensitive data.'],
                    ['icon' => 'ph:arrows-clockwise', 'feature_title' => 'Always evolving', 'feature_text' => 'Qore improves weekly with better prompts, UI, and models — for free.'],
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
        return view('theme::widgets.spotlight-features', compact('settings'))->render();
    }
}
