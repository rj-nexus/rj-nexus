<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class WheelOfFortuneWidget extends BaseWidget
{
    public function id(): string
    {
        return 'wheel-of-fortune';
    }

    public function name(): string
    {
        return __('Wheel of Fortune');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v9l6 3M12 12l-5 6"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A colorful spinning wheel with weighted prizes, confetti, and optional one-time play.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Try your luck!'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => __('Spin the wheel and win a prize'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'spin_label',
                'type'    => 'text',
                'label'   => __('Spin Button Label'),
                'default' => __('SPIN'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'duration',
                'type'    => 'range',
                'label'   => __('Spin Duration (ms)'),
                'default' => 5000,
                'min'     => 2000,
                'max'     => 9000,
                'step'    => 250,
                'tab'     => 'style',
            ],
            [
                'name'    => 'size',
                'type'    => 'select',
                'label'   => __('Wheel Size'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small (280px)'),
                    'md' => __('Medium (360px)'),
                    'lg' => __('Large (440px)'),
                    'xl' => __('Extra Large (520px)'),
                ],
            ],
            [
                'name'    => 'pointer_color',
                'type'    => 'color',
                'label'   => __('Pointer Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'rim_color',
                'type'    => 'color',
                'label'   => __('Outer Rim Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'hub_color',
                'type'    => 'color',
                'label'   => __('Center Button Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'hub_text_color',
                'type'    => 'color',
                'label'   => __('Center Button Text Color'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_confetti',
                'type'    => 'toggle',
                'label'   => __('Confetti on Win'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_result_modal',
                'type'    => 'toggle',
                'label'   => __('Show Result Modal'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'one_time',
                'type'    => 'toggle',
                'label'   => __('One Spin Per Visitor'),
                'default' => false,
                'tab'     => 'content',
                'help'    => __('Uses browser storage to lock after one spin. Changing prizes resets the lock.'),
            ],
            [
                'name'    => 'one_time_message',
                'type'    => 'text',
                'label'   => __('Already Played Message'),
                'default' => __('You have already spun the wheel!'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'claimed_label',
                'type'    => 'text',
                'label'   => __('Already Won Label'),
                'default' => __('You won:'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 60,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'   => 'segments',
                'type'   => 'repeater',
                'label'  => __('Wheel Segments'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'label',       'type' => 'text',     'label' => __('Label')],
                    ['name' => 'color',       'type' => 'text',     'label' => __('Color (hex)')],
                    ['name' => 'weight',      'type' => 'text',     'label' => __('Weight (default 1)')],
                    ['name' => 'description', 'type' => 'textarea', 'label' => __('Description (shown in result)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'wf_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.wheel-of-fortune', compact('settings', 'uid'))->render();
    }
}
