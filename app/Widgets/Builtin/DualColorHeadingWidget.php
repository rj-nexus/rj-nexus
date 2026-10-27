<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class DualColorHeadingWidget extends BaseWidget
{
    public function id(): string
    {
        return 'dual-color-heading';
    }

    public function name(): string
    {
        return __('Dual Color Heading');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h8v2H4zM14 6h6v2h-6zM4 12h10v2H4zM16 12h4v2h-4zM4 18h6v2H4zM12 18h8v2h-8z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A heading with two colors — split, gradient, outlined, or per-letter effects.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'before',
                'type'    => 'text',
                'label'   => __('First Part'),
                'default' => __('We build'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'after',
                'type'    => 'text',
                'label'   => __('Second Part (accent color)'),
                'default' => __('amazing websites'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'tag',
                'type'    => 'select',
                'label'   => __('HTML Tag'),
                'default' => 'h2',
                'tab'     => 'content',
                'options' => [
                    'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'div' => 'div',
                ],
            ],
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Style'),
                'default' => 'solid',
                'tab'     => 'content',
                'options' => [
                    'solid'     => __('Two Solid Colors'),
                    'gradient'  => __('Gradient (both parts)'),
                    'outline'   => __('Outlined (second part)'),
                    'highlight' => __('Highlighted Background'),
                    'underline' => __('Underlined Second Part'),
                ],
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'inline',
                'tab'     => 'style',
                'options' => [
                    'inline'   => __('Inline (same line)'),
                    'stacked'  => __('Stacked (two lines)'),
                ],
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
                    '4xl' => __('Giant'),
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
                'name'    => 'color_before',
                'type'    => 'color',
                'label'   => __('First Part Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'color_after',
                'type'    => 'color',
                'label'   => __('Second Part Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'gradient_end',
                'type'    => 'color',
                'label'   => __('Gradient End Color'),
                'default' => '#ec4899',
                'tab'     => 'style',
                'help'    => __('Used only for gradient style.'),
            ],
            [
                'name'    => 'highlight_bg',
                'type'    => 'color',
                'label'   => __('Highlight Background'),
                'default' => '#fef3c7',
                'tab'     => 'style',
                'help'    => __('Used only for highlight style.'),
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
        $uid = 'dch_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.dual-color-heading', compact('settings', 'uid'))->render();
    }
}
