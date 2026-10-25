<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AdvancedSearchWidget extends BaseWidget
{
    public function id(): string
    {
        return 'advanced-search';
    }

    public function name(): string
    {
        return __('Advanced Search');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>';
    }

    public function category(): string
    {
        return 'navigation';
    }

    public function description(): string
    {
        return __('A live AJAX search bar with autocomplete results.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'placeholder',
                'type' => 'text',
                'label' => __('Placeholder Text'),
                'default' => __('Search for products, posts...'),
                'tab' => 'content',
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'minimal',
                'tab' => 'style',
                'options' => [
                    'minimal' => __('Minimal (Underline)'),
                    'filled' => __('Filled (Gray Background)'),
                    'dark' => __('Dark Theme'),
                ],
            ],
            [
                'name' => 'show_image',
                'type' => 'toggle',
                'label' => __('Show Result Images'),
                'default' => true,
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'search_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.advanced-search', compact('settings', 'uid'))->render();
    }
}
