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
        return __('Interactive glassmorphism tabs with animated text content.');
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
                        'content_title' => 'Generate stunning visuals in seconds.',
                        'content_text' => 'Turn your imagination into high-resolution art with a single prompt. No design skills required.'
                    ],
                    [
                        'tab_title' => 'Code Composer',
                        'content_title' => 'Write better code, faster.',
                        'content_text' => 'From debugging to full-stack generation, let AI handle the heavy lifting.'
                    ],
                    [
                        'tab_title' => 'Website Builder',
                        'content_title' => 'Launch your next big idea.',
                        'content_text' => 'Create fully responsive landing pages with intelligent layout suggestions.'
                    ]
                ],
                'fields' => [
                    [
                        'name' => 'tab_title',
                        'type' => 'text',
                        'label' => __('Tab Button Text'),
                        'default' => 'New Tab',
                    ],
                    [
                        'name' => 'content_title',
                        'type' => 'text',
                        'label' => __('Heading (Big Text)'),
                        'default' => 'Feature Title',
                    ],
                    [
                        'name' => 'content_text',
                        'type' => 'textarea',
                        'label' => __('Description'),
                        'default' => 'Feature description goes here.',
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
