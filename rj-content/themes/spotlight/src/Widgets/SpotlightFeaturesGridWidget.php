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
                'default' => 'Badge Text',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'Main Title',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => '',
            ],
            [
                'name' => 'features',
                'type' => 'repeater',
                'label' => __('Features (Max 6)'),
                'max_items' => 6,
                'default' => [
                    [
                        'icon' => 'ph:star',
                        'title' => 'Feature 1',
                        'desc' => 'Description goes here.',
                    ],
                    [
                        'icon' => 'ph:star',
                        'title' => 'Feature 2',
                        'desc' => 'Description goes here.',
                    ],
                    [
                        'icon' => 'ph:star',
                        'title' => 'Feature 3',
                        'desc' => 'Description goes here.',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'icon',
                        'type' => 'icon',
                        'label' => __('Icon (Iconify)'),
                        'default' => 'ph:star',
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
