<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AnimatedHeadlineWidget extends BaseWidget
{
    public function id(): string
    {
        return 'animated-headline';
    }

    public function name(): string
    {
        return __('Animated Headline');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h14"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 4l3 3-3 3"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('An animated headline with typing, drawing, and hover effects on the highlighted word.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'text_before',
                'type'    => 'text',
                'label'   => __('Text Before'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'text_highlight',
                'type'    => 'text',
                'label'   => __('Highlighted Text'),
                'default' => __('Amazing'),
                'tab'     => 'content',
                'help'    => __('This part receives the effect and hover color.'),
            ],
            [
                'name'    => 'text_after',
                'type'    => 'text',
                'label'   => __('Text After'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'tag',
                'type'    => 'select',
                'label'   => __('HTML Tag'),
                'default' => 'h2',
                'tab'     => 'content',
                'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'div' => 'div'],
            ],
            [
                'name'    => 'effect',
                'type'    => 'select',
                'label'   => __('Highlight Effect'),
                'default' => 'underline',
                'tab'     => 'content',
                'options' => [
                    'underline' => __('Underline'),
                    'circle'    => __('Circle'),
                    'typing'    => __('Typing'),
                    'highlight' => __('Background'),
                    'none'      => __('None'),
                ],
            ],
            [
                'name'    => 'underline_style',
                'type'    => 'select',
                'label'   => __('Underline Style'),
                'default' => 'pen',
                'tab'     => 'content',
                'options' => [
                    'pen'    => __('Pen Stroke'),
                    'brush'  => __('Brush'),
                    'wave'   => __('Wave'),
                    'plain'  => __('Plain'),
                    'double' => __('Double'),
                    'dashed' => __('Dashed'),
                ],
                'help'    => __('Applies only to the Underline effect.'),
            ],
            [
                'name'    => 'direction',
                'type'    => 'select',
                'label'   => __('Animation Direction'),
                'default' => 'left',
                'tab'     => 'content',
                'options' => [
                    'left'  => __('Left → Right'),
                    'right' => __('Right → Left'),
                    'both'  => __('Both Sides'),
                ],
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'center',
                'tab'     => 'style',
                'options' => ['left' => __('Left'), 'center' => __('Center'), 'right' => __('Right')],
            ],
            [
                'name'    => 'size',
                'type'    => 'select',
                'label'   => __('Size'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'lg'  => __('Large'),
                    'xl'  => __('Extra Large'),
                    '2xl' => __('Huge'),
                    '3xl' => __('Massive'),
                ],
            ],
            [
                'name'    => 'weight',
                'type'    => 'select',
                'label'   => __('Font Weight'),
                'default' => '800',
                'tab'     => 'style',
                'options' => ['600' => '600', '700' => '700', '800' => '800', '900' => '900'],
            ],
            [
                'name'    => 'color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'hover_change',
                'type'    => 'toggle',
                'label'   => __('Color Change on Hover'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'hover_color',
                'type'    => 'color',
                'label'   => __('Hover Color'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'animate',
                'type'    => 'toggle',
                'label'   => __('Animate on Load'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 40,
                'min'     => 0,
                'max'     => 120,
                'step'    => 4,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'ah_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.animated-headline', compact('settings', 'uid'))->render();
    }
}
