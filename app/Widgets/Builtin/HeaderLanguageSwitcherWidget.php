<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class HeaderLanguageSwitcherWidget extends BaseWidget
{
    public function id(): string
    {
        return 'header-language';
    }

    public function name(): string
    {
        return __('Header Language Switcher');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3a15.3 15.3 0 014 9 15.3 15.3 0 01-4 9 15.3 15.3 0 01-4-9 15.3 15.3 0 014-9z"/></svg>';
    }

    public function category(): string
    {
        return 'header';
    }

    public function description(): string
    {
        return __('A compact language switcher for the header — dropdown, inline flags or pills.');
    }

    public function contexts(): array
    {
        return ['header'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Style'),
                'default' => 'dropdown',
                'tab'     => 'content',
                'options' => [
                    'dropdown'    => __('Dropdown'),
                    'inline-flags'=> __('Inline Flags'),
                    'inline-names'=> __('Inline Names'),
                    'pills'       => __('Pills'),
                ],
            ],
            [
                'name'    => 'show_flag',
                'type'    => 'toggle',
                'label'   => __('Show Flag'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_name',
                'type'    => 'toggle',
                'label'   => __('Show Language Name'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_full_name',
                'type'    => 'toggle',
                'label'   => __('Show Full Language Name'),
                'default' => false,
                'tab'     => 'style',
                'help'    => __('Show "English" instead of "EN".'),
            ],
            [
                'name'    => 'show_arrow',
                'type'    => 'toggle',
                'label'   => __('Show Dropdown Arrow'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'dropdown_align',
                'type'    => 'select',
                'label'   => __('Dropdown Alignment'),
                'default' => 'auto',
                'tab'     => 'style',
                'options' => [
                    'auto'  => __('Auto'),
                    'left'  => __('Left'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name'    => 'size',
                'type'    => 'select',
                'label'   => __('Size'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'btn_style',
                'type'    => 'select',
                'label'   => __('Button Style'),
                'default' => 'ghost',
                'tab'     => 'style',
                'options' => [
                    'ghost'   => __('Ghost'),
                    'outline' => __('Outline'),
                    'soft'    => __('Soft'),
                    'solid'   => __('Solid Accent'),
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
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Radius'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'sm'   => __('Small'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'full' => __('Full (pill)'),
                ],
            ],
            [
                'name'    => 'show_code_on_compact',
                'type'    => 'toggle',
                'label'   => __('Show Code on Compact Mode'),
                'default' => true,
                'tab'     => 'style',
                'help'    => __('When both flag and name are hidden, shows the 2-letter code.'),
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'hls_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.header-language-switcher', compact('settings', 'uid'))->render();
    }
}
