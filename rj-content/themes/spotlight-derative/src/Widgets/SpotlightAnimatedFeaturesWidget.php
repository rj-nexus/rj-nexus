<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightActionGridWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-action-grid';
    }

    public function name(): string
    {
        return __('Spotlight Action Grid (Contact)');
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
        return __('A 3-column layout with cornered icons, titles, text and buttons. Perfect for Contact pages.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'main_title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => "We'd love to hear from you.",
            ],
            [
                'name' => 'items',
                'type' => 'repeater',
                'label' => __('Grid Items (Max 4)'),
                'max_items' => 4,
                'default' => [
                    [
                        'icon' => 'ph:presentation-chart',
                        'title' => 'Request a Demo',
                        'desc' => 'Schedule a personalized walkthrough to see how our solution fits your needs.',
                        'btn_text' => 'Book Demo',
                        'btn_url' => '#',
                    ],
                    [
                        'icon' => 'ph:chat-teardrop-dots',
                        'title' => 'Customer Support',
                        'desc' => 'Our dedicated team is available around the clock to assist you.',
                        'btn_text' => 'Start Chat',
                        'btn_url' => '#',
                    ],
                    [
                        'icon' => 'ph:handshake',
                        'title' => 'Partnership',
                        'desc' => 'Interested in collaborating? Let us discuss how we can grow together.',
                        'btn_text' => 'Contact Sales',
                        'btn_url' => '#',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'icon',
                        'type' => 'icon',
                        'label' => __('Icon'),
                        'default' => 'ph:star',
                        'help' => 'e.g. ph:rocket-launch, ph:cpu.',
                        'help_link' => 'https://iconify.design/',
                        'help_link_text' => __('Browse Icons on Iconify ->')
                    ],
                    [
                        'name' => 'title',
                        'type' => 'text',
                        'label' => __('Title'),
                        'default' => 'Feature',
                    ],
                    [
                        'name' => 'desc',
                        'type' => 'textarea',
                        'label' => __('Description'),
                        'default' => 'Description goes here.',
                    ],
                    [
                        'name' => 'btn_text',
                        'type' => 'text',
                        'label' => __('Button Text'),
                        'default' => 'Click Here',
                    ],
                    [
                        'name' => 'btn_url',
                        'type' => 'text',
                        'label' => __('Button URL'),
                        'default' => '#',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-action-grid', compact('settings'))->render();
    }
}
