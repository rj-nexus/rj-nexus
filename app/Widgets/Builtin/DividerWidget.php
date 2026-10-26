<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class DividerWidget extends BaseWidget
{
    public function id(): string
    {
        return 'divider';
    }

    public function name(): string
    {
        return __('Divider / Spacer');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M4 6h16M4 18h16"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('Add lines to separate content or empty space to push elements down.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'type',
                'type' => 'select',
                'label' => __('Type'),
                'default' => 'divider',
                'tab' => 'content',
                'options' => [
                    'divider' => __('Divider (Line)'),
                    'spacer' => __('Spacer (Empty Space)'),
                ],
            ],
            [
                'name' => 'spacer_height',
                'type' => 'text',
                'label' => __('Spacer Height'),
                'default' => '50px',
                'tab' => 'content',
                'help' => __('e.g. 50px, 10vh, 2rem. Used only when Type is Spacer.'),
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Divider Style'),
                'default' => 'solid',
                'tab' => 'style',
                'options' => [
                    'solid' => __('Solid Line'),
                    'dashed' => __('Dashed Line'),
                    'dotted' => __('Dotted Line'),
                    'gradient' => __('Gradient Line'),
                    'icon' => __('Line with Icon in Center'),
                    'text' => __('Line with Text in Center'),
                ],
            ],
            [
                'name' => 'color',
                'type' => 'color',
                'label' => __('Line / Text Color'),
                'default' => '#e2e8f0',
                'tab' => 'style',
            ],
            [
                'name' => 'gradient_color_1',
                'type' => 'color',
                'label' => __('Gradient Start (Left)'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'gradient_color_2',
                'type' => 'color',
                'label' => __('Gradient End (Right)'),
                'default' => '#ec4899',
                'tab' => 'style',
            ],
            [
                'name' => 'thickness',
                'type' => 'number',
                'label' => __('Line Thickness (px)'),
                'default' => 1,
                'tab' => 'style',
            ],
            [
                'name' => 'width',
                'type' => 'select',
                'label' => __('Width'),
                'default' => '100%',
                'tab' => 'style',
                'options' => [
                    '100%' => __('Full Width'),
                    '75%' => __('75% Width'),
                    '50%' => __('50% Width'),
                    '25%' => __('25% Width'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'center_icon',
                'type' => 'icon',
                'label' => __('Center Icon'),
                'default' => 'ph:star-fill',
                'tab' => 'style',
                'help' => __('Used only when Style is Icon.'),
            ],
            [
                'name' => 'center_text',
                'type' => 'text',
                'label' => __('Center Text'),
                'default' => __('OR'),
                'tab' => 'style',
                'help' => __('Used only when Style is Text.'),
            ],
            [
                'name' => 'margin_top',
                'type' => 'number',
                'label' => __('Top Margin (px)'),
                'default' => 24,
                'tab' => 'style',
            ],
            [
                'name' => 'margin_bottom',
                'type' => 'number',
                'label' => __('Bottom Margin (px)'),
                'default' => 24,
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'div_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.divider', compact('settings', 'uid'))->render();
    }
}
