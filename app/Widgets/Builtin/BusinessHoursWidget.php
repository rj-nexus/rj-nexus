<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class BusinessHoursWidget extends BaseWidget
{
    public function id(): string
    {
        return 'business-hours';
    }

    public function name(): string
    {
        return __('Business Hours');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Weekly opening hours with today highlighted, live open/closed status and timezone support.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('Opening Hours'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Subtitle'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'timezone',
                'type'    => 'select',
                'label'   => __('Timezone'),
                'default' => 'auto',
                'tab'     => 'content',
                'options' => [
                    'auto'      => __('Visitor Timezone (browser)'),
                    'Asia/Baku' => 'Asia/Baku',
                    'UTC'       => 'UTC',
                    'Europe/London'      => 'Europe/London',
                    'Europe/Berlin'      => 'Europe/Berlin',
                    'Europe/Paris'       => 'Europe/Paris',
                    'Europe/Istanbul'    => 'Europe/Istanbul',
                    'Europe/Moscow'      => 'Europe/Moscow',
                    'Asia/Dubai'         => 'Asia/Dubai',
                    'Asia/Tokyo'         => 'Asia/Tokyo',
                    'America/New_York'   => 'America/New_York',
                    'America/Los_Angeles'=> 'America/Los_Angeles',
                ],
            ],
            [
                'name'    => 'time_format',
                'type'    => 'select',
                'label'   => __('Time Format'),
                'default' => '24h',
                'tab'     => 'style',
                'options' => [
                    '24h' => __('24-hour (14:30)'),
                    '12h' => __('12-hour (2:30 PM)'),
                ],
            ],
            [
                'name'    => 'show_status',
                'type'    => 'toggle',
                'label'   => __('Show Live Open/Closed Status'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_week',
                'type'    => 'toggle',
                'label'   => __('Show Full Week'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'highlight_today',
                'type'    => 'toggle',
                'label'   => __('Highlight Today'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'card',
                'tab'     => 'style',
                'options' => [
                    'card'    => __('Card'),
                    'minimal' => __('Minimal'),
                    'split'   => __('Split (2 columns)'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'muted_color',
                'type'    => 'color',
                'label'   => __('Muted Text Color'),
                'default' => '#64748b',
                'tab'     => 'style',
            ],
            [
                'name'    => 'closed_label',
                'type'    => 'text',
                'label'   => __('Closed Label'),
                'default' => __('Closed'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'open_label',
                'type'    => 'text',
                'label'   => __('Open Label'),
                'default' => __('Open Now'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'closed_now_label',
                'type'    => 'text',
                'label'   => __('Currently Closed Label'),
                'default' => __('Closed Now'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'footer_note',
                'type'    => 'text',
                'label'   => __('Footer Note'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'xl'   => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 40,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'    => 'schedule',
                'type'    => 'repeater',
                'label'   => __('Weekly Schedule'),
                'tab'     => 'content',
                'fields' => [
                    ['name' => 'day',       'type' => 'select', 'label' => __('Day'), 'options' => [
                        'mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday',
                        'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday',
                    ]],
                    ['name' => 'open',      'type' => 'text', 'label' => __('Opens (e.g. 09:00)')],
                    ['name' => 'close',     'type' => 'text', 'label' => __('Closes (e.g. 18:00)')],
                    ['name' => 'closed',    'type' => 'select', 'label' => __('Closed?'), 'options' => ['0' => __('No'), '1' => __('Yes')]],
                    ['name' => 'note',      'type' => 'text', 'label' => __('Note (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'bh_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.business-hours', compact('settings', 'uid'))->render();
    }
}
