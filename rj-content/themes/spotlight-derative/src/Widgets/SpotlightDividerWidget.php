<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightDividerWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-divider';
    }

    public function name(): string
    {
        return __('Spotlight Divider');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16m0 0l-4-4m4 4l-4 4"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A static divider with repeating background text and thin glass borders.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Height'),
                'default' => 'md',
                'options' => [
                    'sm' => __('Small (40px)'),
                    'md' => __('Medium (80px)'),
                    'lg' => __('Large (120px)'),
                    'xl' => __('Extra Large (200px)'),
                ],
            ],
            [
                'name' => 'text',
                'type' => 'text',
                'label' => __('Repeating Text'),
                'default' => 'loremipsum',
            ],
            [
                'name' => 'text_size',
                'type' => 'select',
                'label' => __('Text Size'),
                'default' => 'md',
                'options' => [
                    'sm' => __('Small (24px)'),
                    'md' => __('Medium (48px)'),
                    'lg' => __('Large (80px)'),
                ],
            ],
            [
                'name' => 'text_opacity',
                'type' => 'number',
                'label' => __('Text Opacity (0-100)'),
                'default' => 5,
            ],
            [
                'name' => 'border_style',
                'type' => 'select',
                'label' => __('Border Style'),
                'default' => 'gradient',
                'options' => [
                    'solid' => __('Solid Line'),
                    'gradient' => __('Fading Gradient Line'),
                    'none' => __('No Borders'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-divider', compact('settings'))->render();
    }
}
