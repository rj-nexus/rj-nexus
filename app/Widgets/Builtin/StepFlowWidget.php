<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class StepFlowWidget extends BaseWidget
{
    public function id(): string
    {
        return 'step-flow';
    }

    public function name(): string
    {
        return __('Step Flow');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h4v4H4zM10 14h4v4h-4zM16 6h4v4h-4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 8h6a2 2 0 012 2v4M8 6v2"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A step-by-step process timeline with horizontal, vertical, and alternating layouts.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('How it works'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'desc',
                'type'    => 'textarea',
                'label'   => __('Section Description'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'horizontal',
                'tab'     => 'style',
                'options' => [
                    'horizontal'  => __('Horizontal'),
                    'vertical'    => __('Vertical'),
                    'alternating' => __('Alternating'),
                ],
            ],
            [
                'name'    => 'number_style',
                'type'    => 'select',
                'label'   => __('Number Style'),
                'default' => 'circle',
                'tab'     => 'style',
                'options' => [
                    'circle'  => __('Solid Circle'),
                    'outline' => __('Outline Circle'),
                    'square'  => __('Rounded Square'),
                    'gradient'=> __('Gradient'),
                    'icon'    => __('Custom Icon'),
                ],
            ],
            [
                'name'    => 'connector',
                'type'    => 'select',
                'label'   => __('Connector Style'),
                'default' => 'line',
                'tab'     => 'style',
                'options' => [
                    'line'   => __('Solid Line'),
                    'dashed' => __('Dashed Line'),
                    'arrow'  => __('Arrow Line'),
                    'dotted' => __('Dotted Line'),
                    'none'   => __('None'),
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
                'name'    => 'accent2',
                'type'    => 'color',
                'label'   => __('Accent Gradient End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Title Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'muted_color',
                'type'    => 'color',
                'label'   => __('Description Color'),
                'default' => '#64748b',
                'tab'     => 'style',
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Text Alignment'),
                'default' => 'center',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                ],
            ],
            [
                'name'    => 'animate',
                'type'    => 'toggle',
                'label'   => __('Animate on Scroll'),
                'default' => true,
                'tab'     => 'style',
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
                'name'    => 'steps',
                'type'    => 'repeater',
                'label'   => __('Steps'),
                'tab'     => 'content',
                'fields' => [
                    ['name' => 'title',  'type' => 'text',     'label' => __('Step Title')],
                    ['name' => 'desc',   'type' => 'textarea', 'label' => __('Step Description')],
                    ['name' => 'icon',   'type' => 'icon',     'label' => __('Step Icon (optional)')],
                    ['name' => 'image',  'type' => 'media',    'label' => __('Step Image (optional)')],
                    ['name' => 'link',   'type' => 'text',     'label' => __('Link URL (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'st_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.step-flow', compact('settings', 'uid'))->render();
    }
}
