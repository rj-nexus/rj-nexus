<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class LottieWidget extends BaseWidget
{
    public function id(): string
    {
        return 'lottie';
    }

    public function name(): string
    {
        return __('Lottie Animation');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 12v3M3 12h3m12 0h3M5.6 5.6l2.1 2.1m8.6 8.6l2.1 2.1M5.6 18.4l2.1-2.1m8.6-8.6l2.1-2.1"/><circle cx="12" cy="12" r="4"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('A Lottie JSON animation player with hover, scroll and click triggers plus fallback image.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'source_type',
                'type'    => 'select',
                'label'   => __('Source'),
                'default' => 'url',
                'tab'     => 'content',
                'options' => [
                    'url'  => __('Remote URL'),
                    'json' => __('Paste JSON'),
                ],
            ],
            [
                'name'    => 'url',
                'type'    => 'text',
                'label'   => __('Lottie JSON URL'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Example: https://assets.lottiefiles.com/packages/lf20_xxxxx.json'),
            ],
            [
                'name'    => 'json_data',
                'type'    => 'textarea',
                'label'   => __('Paste Lottie JSON'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Paste the contents of a Lottie JSON file here.'),
            ],
            [
                'name'    => 'fallback',
                'type'    => 'media',
                'label'   => __('Fallback Image'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Shown if Lottie fails to load.'),
            ],
            [
                'name'    => 'trigger',
                'type'    => 'select',
                'label'   => __('Trigger'),
                'default' => 'autoplay',
                'tab'     => 'style',
                'options' => [
                    'autoplay' => __('Autoplay'),
                    'hover'    => __('Play on Hover'),
                    'scroll'   => __('Play on Scroll Into View'),
                    'click'    => __('Play on Click'),
                ],
            ],
            [
                'name'    => 'loop',
                'type'    => 'toggle',
                'label'   => __('Loop'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'speed',
                'type'    => 'range',
                'label'   => __('Speed'),
                'default' => 100,
                'min'     => 20,
                'max'     => 300,
                'step'    => 5,
                'tab'     => 'style',
            ],
            [
                'name'    => 'direction',
                'type'    => 'select',
                'label'   => __('Direction'),
                'default' => '1',
                'tab'     => 'style',
                'options' => [
                    '1'  => __('Forward'),
                    '-1' => __('Reverse'),
                ],
            ],
            [
                'name'    => 'size',
                'type'    => 'select',
                'label'   => __('Size'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm'   => __('Small (200px)'),
                    'md'   => __('Medium (320px)'),
                    'lg'   => __('Large (480px)'),
                    'xl'   => __('Extra Large (640px)'),
                    'full' => __('Full Width'),
                ],
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'center',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                    'right'  => __('Right'),
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
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'lt_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.lottie', compact('settings', 'uid'))->render();
    }
}
