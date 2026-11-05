<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightTeamWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-team';
    }

    public function name(): string
    {
        return __('Spotlight Team');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A team member grid with hover effects and gradient overlays. Max 9 members.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'Meet our experts',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle (Optional)'),
                'default' => '',
            ],
            [
                'name' => 'members',
                'type' => 'repeater',
                'label' => __('Team Members (Max 9)'),
                'max_items' => 9,
                'default' => [
                    ['name' => 'Annette Black', 'role' => 'Creative Director', 'image' => ''],
                    ['name' => 'Albert Flores', 'role' => 'Creative Director', 'image' => ''],
                    ['name' => 'Cameron Williamson', 'role' => 'Creative Director', 'image' => ''],
                    ['name' => 'Wade Warren', 'role' => 'Creative Director', 'image' => ''],
                    ['name' => 'Annette Black', 'role' => 'Creative Director', 'image' => ''],
                    ['name' => 'Arlene McCoy', 'role' => 'Creative Director', 'image' => ''],
                ],
                'fields' => [
                    [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => __('Name'),
                        'default' => 'John Doe',
                    ],
                    [
                        'name' => 'role',
                        'type' => 'text',
                        'label' => __('Role'),
                        'default' => 'Position',
                    ],
                    [
                        'name' => 'image',
                        'type' => 'media',
                        'label' => __('Profile Image'),
                        'default' => '',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-team', compact('settings'))->render();
    }
}
