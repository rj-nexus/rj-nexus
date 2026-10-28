<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class LayoutContainerWidget extends BaseWidget
{
    public function id(): string
    {
        return 'layout-container';
    }

    public function name(): string
    {
        return __('Flex Layout Container');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('A flexible container for headers, footers, and blocks. Allows multi-row layouts.');
    }

    public function contexts(): array
    {
        return ['header', 'footer', 'block', 'popup'];
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'direction',
                'type' => 'select',
                'label' => __('Direction'),
                'default' => 'row',
                'tab' => 'content',
                'options' => [
                    'row' => __('Row (Horizontal)'),
                    'column' => __('Column (Vertical)'),
                ],
            ],
            [
                'name' => 'justify',
                'type' => 'select',
                'label' => __('Justify Content'),
                'default' => 'space-between',
                'tab' => 'content',
                'options' => [
                    'flex-start' => __('Start'),
                    'center' => __('Center'),
                    'flex-end' => __('End'),
                    'space-between' => __('Space Between'),
                    'space-around' => __('Space Around'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Align Items'),
                'default' => 'center',
                'tab' => 'content',
                'options' => [
                    'flex-start' => __('Start'),
                    'center' => __('Center'),
                    'flex-end' => __('End'),
                    'stretch' => __('Stretch'),
                ],
            ],
            [
                'name' => 'wrap',
                'type' => 'select',
                'label' => __('Wrap'),
                'default' => 'wrap',
                'tab' => 'content',
                'options' => [
                    'wrap' => __('Wrap (Mobile friendly)'),
                    'nowrap' => __('No Wrap'),
                ],
            ],
            [
                'name' => 'gap',
                'type' => 'select',
                'label' => __('Gap'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                    'xl' => __('Extra Large'),
                ],
            ],
            [
                'name' => 'padding_dim',
                'type' => 'dimensions',
                'label' => __('Padding'),
                'default' => ['top' => '', 'right' => '', 'bottom' => '', 'left' => '', 'unit' => 'px', 'linked' => false],
                'tab' => 'style',
            ],
            [
                'name' => 'margin_dim',
                'type' => 'dimensions',
                'label' => __('Margin'),
                'default' => ['top' => '', 'right' => '', 'bottom' => '', 'left' => '', 'unit' => 'px', 'linked' => false],
                'tab' => 'style',
            ],
            [
                'name' => 'bg_color',
                'type' => 'color',
                'label' => __('Background Color'),
                'default' => 'transparent',
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings, array $children = []): string
    {
        $direction = $settings['direction'] ?? 'row';
        $justify   = $settings['justify'] ?? 'space-between';
        $align     = $settings['align'] ?? 'center';
        $wrap      = $settings['wrap'] ?? 'wrap';
        $gap       = $settings['gap'] ?? 'md';
        $bgColor   = $settings['bg_color'] ?? 'transparent';

        $gapMap = ['none' => '0', 'sm' => '12px', 'md' => '24px', 'lg' => '36px', 'xl' => '48px'];
        $gapCss = $gapMap[$gap] ?? '24px';

        $styles = [
            'display'         => 'flex',
            'flex-direction'  => $direction,
            'justify-content' => $justify,
            'align-items'     => $align,
            'flex-wrap'       => $wrap,
            'gap'             => $gapCss,
            'width'           => '100%',
        ];

        if ($bgColor !== 'transparent' && $bgColor !== '') {
            $styles['background-color'] = $bgColor;
        }

        $padding = $this->dimensionCss($settings, 'padding_dim');
        if ($padding !== '') {
            $styles['padding'] = $padding;
        }

        $margin = $this->dimensionCss($settings, 'margin_dim');
        if ($margin !== '') {
            $styles['margin'] = $margin;
        }

        $styleStr = '';
        foreach ($styles as $key => $val) {
            $styleStr .= "{$key}: {$val}; ";
        }

        return view('rjbuilder.widgets.builtin.layout-container', compact('styleStr', 'children'))->render();
    }
}
