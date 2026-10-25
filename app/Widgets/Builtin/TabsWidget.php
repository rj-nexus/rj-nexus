<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class TabsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'tabs';
    }

    public function name(): string
    {
        return __('Tabs');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Organize content into switchable tabs.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Tab Style'),
                'default' => 'underline',
                'tab' => 'style',
                'options' => [
                    'underline' => __('Underline (Minimal)'),
                    'pills' => __('Pills (Rounded)'),
                    'boxed' => __('Boxed (Solid)'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Tab Alignment'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                ],
            ],
            [
                'name' => 'active_color',
                'type' => 'color',
                'label' => __('Active Tab Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'inactive_color',
                'type' => 'color',
                'label' => __('Inactive Tab Text Color'),
                'default' => '#64748b',
                'tab' => 'style',
            ],
            [
                'name' => 'text_color',
                'type' => 'color',
                'label' => __('Content Text Color'),
                'default' => '#334155',
                'tab' => 'style',
            ],

            // Tab 1
            ['name' => 't1_title', 'type' => 'text', 'label' => __('Tab 1 - Title'), 'default' => __('Description'), 'tab' => 'content'],
            ['name' => 't1_content', 'type' => 'textarea', 'label' => __('Tab 1 - Content (HTML supported)'), 'default' => __('<p>This is the description tab content.</p>'), 'tab' => 'content'],

            // Tab 2
            ['name' => 't2_title', 'type' => 'text', 'label' => __('Tab 2 - Title'), 'default' => __('Shipping & Returns'), 'tab' => 'content'],
            ['name' => 't2_content', 'type' => 'textarea', 'label' => __('Tab 2 - Content (HTML supported)'), 'default' => __('<p>Details about shipping and return policies go here.</p>'), 'tab' => 'content'],

            // Tab 3
            ['name' => 't3_title', 'type' => 'text', 'label' => __('Tab 3 - Title'), 'default' => __('Reviews'), 'tab' => 'content'],
            ['name' => 't3_content', 'type' => 'textarea', 'label' => __('Tab 3 - Content (HTML supported)'), 'default' => __('<p>Customer reviews will appear here.</p>'), 'tab' => 'content'],

            // Tab 4
            ['name' => 't4_title', 'type' => 'text', 'label' => __('Tab 4 - Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 't4_content', 'type' => 'textarea', 'label' => __('Tab 4 - Content (HTML supported)'), 'default' => '', 'tab' => 'content'],
        ];
    }

    public function render(array $settings): string
    {
        $tabs = [];
        for ($i = 1; $i <= 4; $i++) {
            if (!empty($settings['t'.$i.'_title'])) {
                $tabs[] = [
                    'title' => $settings['t'.$i.'_title'],
                    'content' => $settings['t'.$i.'_content'] ?? '',
                ];
            }
        }

        if (empty($tabs)) {
            return '';
        }

        $uid = 'tabs_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.tabs', compact('settings', 'tabs', 'uid'))->render();
    }
}
