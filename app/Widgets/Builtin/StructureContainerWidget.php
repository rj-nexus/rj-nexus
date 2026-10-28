<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class StructureContainerWidget extends BaseWidget
{
    public function id(): string
    {
        return 'structure-container';
    }

    public function name(): string
    {
        return __('Flex Container');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke-dasharray="4 4"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v18"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('A flexible container for structural templates (Header, Footer, etc.).');
    }

    public function contexts(): array
    {
        return ['header', 'footer', 'block', 'popup'];
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'columns',
                'type' => 'select',
                'label' => __('Columns'),
                'default' => '3',
                'tab' => 'content',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                    '5' => __('5 Columns'),
                ],
            ],
            [
                'name' => 'flex_direction',
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
                'name' => 'flex_wrap',
                'type' => 'select',
                'label' => __('Wrap'),
                'default' => 'nowrap',
                'tab' => 'content',
                'options' => [
                    'nowrap' => __('No Wrap (Keep on one line)'),
                    'wrap' => __('Wrap (Go to next line if no space)'),
                ],
            ],
            [
                'name' => 'justify_content',
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
                'name' => 'align_items',
                'type' => 'select',
                'label' => __('Align Items'),
                'default' => 'center',
                'tab' => 'content',
                'options' => [
                    'flex-start' => __('Top'),
                    'center' => __('Center'),
                    'flex-end' => __('Bottom'),
                    'stretch' => __('Stretch'),
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
                'name' => 'bg_color',
                'type' => 'color',
                'label' => __('Background Color'),
                'default' => '',
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings, array $children = []): string
    {
        return view('rjbuilder.widgets.builtin.structure-container', compact('settings', 'children'))->render();
    }
}
