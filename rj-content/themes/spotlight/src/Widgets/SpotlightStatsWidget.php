<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightStatsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-stats';
    }

    public function name(): string
    {
        return __('Spotlight Stats');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('Display key metrics and numbers with a glassmorphism layout and counter animation.');
    }

    public function contexts(): array
    {
        return ['page', 'block'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title (Optional)'),
                'default' => __('Trusted by developers worldwide'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'stats',
                'type'    => 'repeater',
                'label'   => __('Stats Items'),
                'tab'     => 'content',
                'fields'  => [
                    [
                        'name'    => 'value',
                        'type'    => 'text',
                        'label'   => __('Value (e.g. 10K+, 99.9%)'),
                        'default' => '100+',
                    ],
                    [
                        'name'    => 'label',
                        'type'    => 'text',
                        'label'   => __('Label'),
                        'default' => __('Happy Clients'),
                    ],
                    [
                        'name'    => 'icon',
                        'type'    => 'icon',
                        'label'   => __('Icon (Optional)'),
                    ],
                ],
                'default' => [
                    [
                        'value' => '10K+',
                        'label' => __('Active Users'),
                        'icon' => 'users',
                    ],
                    [
                        'value' => '99.9%',
                        'label' => __('Uptime Guarantee'),
                        'icon' => 'server',
                    ],
                    [
                        'value' => '24/7',
                        'label' => __('Customer Support'),
                        'icon' => 'headset',
                    ],
                    [
                        'value' => '150+',
                        'label' => __('Countries Served'),
                        'icon' => 'globe',
                    ],
                ],
            ],
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Style'),
                'default' => 'glass',
                'tab'     => 'style',
                'options' => [
                    'glass'   => __('Glassmorphism Cards'),
                    'minimal' => __('Minimal (No Background)'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'st_' . substr(md5(uniqid('', true)), 0, 8);

        return view('spotlight::widgets.stats', compact('settings', 'uid'))->render();
    }
}