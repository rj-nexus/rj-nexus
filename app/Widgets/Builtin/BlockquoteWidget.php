<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class BlockquoteWidget extends BaseWidget
{
    public function id(): string
    {
        return 'blockquote';
    }

    public function name(): string
    {
        return __('Blockquote');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h4v6a4 4 0 01-4 4M15 7h4v6a4 4 0 01-4 4"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('An elegant quote block with five styles, optional author, avatar, and decorative marks.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Style'),
                'default' => 'accent-bar',
                'tab'     => 'content',
                'options' => [
                    'accent-bar'   => __('Accent Bar'),
                    'card'         => __('Card'),
                    'gradient'     => __('Gradient Box'),
                    'big-marks'    => __('Giant Quote Marks'),
                    'minimal'      => __('Minimal'),
                ],
            ],
            [
                'name'    => 'quote',
                'type'    => 'textarea',
                'label'   => __('Quote Text'),
                'default' => __('Design is not just what it looks like and feels like. Design is how it works.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'author',
                'type'    => 'text',
                'label'   => __('Author'),
                'default' => __('Steve Jobs'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'role',
                'type'    => 'text',
                'label'   => __('Author Role / Source'),
                'default' => __('Co-founder of Apple'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'avatar',
                'type'    => 'media',
                'label'   => __('Author Avatar (optional)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'left',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                ],
            ],
            [
                'name'    => 'size',
                'type'    => 'select',
                'label'   => __('Quote Size'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'md'  => __('Medium'),
                    'lg'  => __('Large'),
                    'xl'  => __('Extra Large'),
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
                'label'   => __('Gradient End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Quote Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_marks',
                'type'    => 'toggle',
                'label'   => __('Show Decorative Quote Marks'),
                'default' => true,
                'tab'     => 'style',
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
        $uid = 'bq_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.blockquote', compact('settings', 'uid'))->render();
    }
}
