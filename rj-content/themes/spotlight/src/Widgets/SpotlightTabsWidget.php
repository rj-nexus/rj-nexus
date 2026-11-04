<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightTabsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-tabs';
    }

    public function name(): string
    {
        return __('Spotlight Tabs');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('Interactive glassmorphism tabs with animated content switching.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'tabs',
                'type' => 'repeater',
                'label' => __('Tabs (Max 9)'),
                'max_items' => 9,
                'default' => [
                    [
                        'tab_title' => 'Image Creator',
                        'content_title' => 'AI Image Generation',
                        'content_text' => 'Create stunning visuals from text prompts in seconds.',
                        'content_image' => 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/demo_photo1.png'
                    ],
                    [
                        'tab_title' => 'Code Composer',
                        'content_title' => 'Smart Code Assistant',
                        'content_text' => 'Write, refactor, and debug code with AI precision.',
                        'content_image' => ''
                    ],
                    [
                        'tab_title' => 'Website Builder',
                        'content_title' => 'Launch in Minutes',
                        'content_text' => 'Generate full landing pages and layouts effortlessly.',
                        'content_image' => ''
                    ]
                ],
                'fields' => [
                    [
                        'name' => 'tab_title',
                        'type' => 'text',
                        'label' => __('Tab Title'),
                        'default' => 'New Tab',
                    ],
                    [
                        'name' => 'content_title',
                        'type' => 'text',
                        'label' => __('Content Title'),
                        'default' => 'Feature Title',
                    ],
                    [
                        'name' => 'content_text',
                        'type' => 'textarea',
                        'label' => __('Content Text'),
                        'default' => 'Feature description goes here.',
                    ],
                    [
                        'name' => 'content_image',
                        'type' => 'media',
                        'label' => __('Content Image (Optional)'),
                        'default' => '',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-tabs', compact('settings'))->render();
    }
}
