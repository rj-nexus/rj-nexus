<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class TeamWidget extends BaseWidget
{
    public function id(): string
    {
        return 'team';
    }

    public function name(): string
    {
        return __('Team Members');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Display your team members in stylish cards with social links and expandable view.');
    }

    public function schema(): array
    {
        $schema = [
            [
                'name' => 'columns',
                'type' => 'select',
                'label' => __('Columns'),
                'default' => '3',
                'tab' => 'style',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                ],
            ],
            [
                'name' => 'initial_show',
                'type' => 'number',
                'label' => __('Initially Show (Number)'),
                'default' => 4,
                'tab' => 'content',
                'help' => __('How many members to show before the "Show More" button appears.'),
            ],
            [
                'name' => 'more_btn_text',
                'type' => 'text',
                'label' => __('Show More Button Text'),
                'default' => __('Show More'),
                'tab' => 'content',
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Card Style'),
                'default' => 'light',
                'tab' => 'style',
                'options' => [
                    'light' => __('Light Theme'),
                    'dark' => __('Dark Theme'),
                ],
            ],
        ];

        // 8 Üzv üçün dinamik sahələr
        for ($i = 1; $i <= 8; $i++) {
            $schema[] = ['name' => 'm'.$i.'_image', 'type' => 'media', 'label' => __('Member '.$i.' - Image'), 'default' => '', 'tab' => 'content'];
            $schema[] = ['name' => 'm'.$i.'_name', 'type' => 'text', 'label' => __('Member '.$i.' - Name'), 'default' => $i === 1 ? __('John Doe') : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm'.$i.'_position', 'type' => 'text', 'label' => __('Member '.$i.' - Position'), 'default' => $i === 1 ? __('CEO & Founder') : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm'.$i.'_facebook', 'type' => 'text', 'label' => __('Member '.$i.' - Facebook URL'), 'default' => $i === 1 ? '#' : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm'.$i.'_twitter', 'type' => 'text', 'label' => __('Member '.$i.' - Twitter/X URL'), 'default' => $i === 1 ? '#' : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm'.$i.'_linkedin', 'type' => 'text', 'label' => __('Member '.$i.' - LinkedIn URL'), 'default' => $i === 1 ? '#' : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm'.$i.'_btn_text', 'type' => 'text', 'label' => __('Member '.$i.' - Button Text'), 'default' => $i === 1 ? __('View Profile') : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm'.$i.'_btn_url', 'type' => 'text', 'label' => __('Member '.$i.' - Button URL'), 'default' => $i === 1 ? '#' : '', 'tab' => 'content'];
        }

        return $schema;
    }

    public function render(array $settings): string
    {
        $members = [];
        for ($i = 1; $i <= 8; $i++) {
            if (!empty($settings['m'.$i.'_name'])) {
                $members[] = [
                    'image' => $settings['m'.$i.'_image'] ?? '',
                    'name' => $settings['m'.$i.'_name'],
                    'position' => $settings['m'.$i.'_position'] ?? '',
                    'facebook' => $settings['m'.$i.'_facebook'] ?? '',
                    'twitter' => $settings['m'.$i.'_twitter'] ?? '',
                    'linkedin' => $settings['m'.$i.'_linkedin'] ?? '',
                    'btn_text' => $settings['m'.$i.'_btn_text'] ?? '',
                    'btn_url' => $settings['m'.$i.'_btn_url'] ?? '',
                ];
            }
        }

        if (empty($members)) {
            return '';
        }

        $uid = 'team_' . substr(md5(uniqid()), 0, 6);

        $initialShow = (int)($settings['initial_show'] ?? 4);
        $moreBtnText = $settings['more_btn_text'] ?? __('Show More');

        return view('rjbuilder.widgets.builtin.team', compact('settings', 'members', 'uid', 'initialShow', 'moreBtnText'))->render();
    }
}
