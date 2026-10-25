<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CountdownWidget extends BaseWidget
{
    public function id(): string
    {
        return 'countdown';
    }

    public function name(): string
    {
        return __('Countdown Timer');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'marketing';
    }

    public function description(): string
    {
        return __('A customizable countdown timer for sales, launches, or events.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title'),
                'default' => __('Limited Time Offer!'),
                'tab' => 'content',
            ],
            [
                'name' => 'target_date',
                'type' => 'text',
                'label' => __('Target Date & Time'),
                'default' => '2026-12-31 23:59:59',
                'tab' => 'content',
                'placeholder' => 'YYYY-MM-DD HH:MM:SS',
                'help' => __('Format: YYYY-MM-DD HH:MM:SS (e.g., 2026-12-31 23:59:59)'),
            ],
            [
                'name' => 'expired_text',
                'type' => 'text',
                'label' => __('Expired Text'),
                'default' => __('This offer has ended.'),
                'tab' => 'content',
                'help' => __('Text to show when the countdown reaches zero.'),
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'dark',
                'tab' => 'style',
                'options' => [
                    'dark' => __('Dark Boxes'),
                    'light' => __('Light Boxes'),
                    'transparent' => __('Transparent (Only Text)'),
                ],
            ],
            [
                'name' => 'bg_color',
                'type' => 'color',
                'label' => __('Section Background'),
                'default' => '#0f172a',
                'tab' => 'style',
            ],
            [
                'name' => 'box_bg',
                'type' => 'color',
                'label' => __('Timer Box Background'),
                'default' => '#1e293b',
                'tab' => 'style',
            ],
            [
                'name' => 'accent_color',
                'type' => 'color',
                'label' => __('Number Color (Accent)'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'title_color',
                'type' => 'color',
                'label' => __('Title Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'label_color',
                'type' => 'color',
                'label' => __('Label Color (Days, Hours...)'),
                'default' => '#94a3b8',
                'tab' => 'style',
            ],
            [
                'name' => 'show_days',
                'type' => 'toggle',
                'label' => __('Show Days'),
                'default' => true,
                'tab' => 'content',
            ],
            [
                'name' => 'show_hours',
                'type' => 'toggle',
                'label' => __('Show Hours'),
                'default' => true,
                'tab' => 'content',
            ],
            [
                'name' => 'show_minutes',
                'type' => 'toggle',
                'label' => __('Show Minutes'),
                'default' => true,
                'tab' => 'content',
            ],
            [
                'name' => 'show_seconds',
                'type' => 'toggle',
                'label' => __('Show Seconds'),
                'default' => true,
                'tab' => 'content',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'cd_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.countdown', compact('settings', 'uid'))->render();
    }
}
