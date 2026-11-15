<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightComparisonTableWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-comparison-table';
    }

    public function name(): string
    {
        return __('Spotlight Comparison Table');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A side-by-side comparison table to highlight the differences between your pricing plans.');
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
                'label'   => __('Title'),
                'default' => __('Compare our plans'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'textarea',
                'label'   => __('Subtitle'),
                'default' => __('Find the perfect plan for your needs.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'plans',
                'type'    => 'repeater',
                'label'   => __('Plans (Columns)'),
                'tab'     => 'content',
                'fields'  => [
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => __('Plan Name'),
                        'default' => 'Starter',
                    ],
                    [
                        'name'    => 'price',
                        'type'    => 'text',
                        'label'   => __('Price'),
                        'default' => '$9/mo',
                    ],
                    [
                        'name'    => 'button_text',
                        'type'    => 'text',
                        'label'   => __('Button Text'),
                        'default' => __('Choose Plan'),
                    ],
                    [
                        'name'    => 'button_url',
                        'type'    => 'text',
                        'label'   => __('Button URL'),
                        'default' => '#',
                    ],
                    [
                        'name'    => 'is_popular',
                        'type'    => 'toggle',
                        'label'   => __('Highlight as Popular'),
                        'default' => false,
                    ],
                ],
                'default' => [
                    [
                        'name' => __('Starter'),
                        'price' => __('$9/mo'),
                        'button_text' => __('Get Started'),
                        'is_popular' => false,
                    ],
                    [
                        'name' => __('Pro'),
                        'price' => __('$29/mo'),
                        'button_text' => __('Get Started'),
                        'is_popular' => true,
                    ],
                    [
                        'name' => __('Enterprise'),
                        'price' => __('$99/mo'),
                        'button_text' => __('Contact Sales'),
                        'is_popular' => false,
                    ],
                ],
            ],
            [
                'name'    => 'features',
                'type'    => 'repeater',
                'label'   => __('Features (Rows)'),
                'tab'     => 'content',
                'fields'  => [
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => __('Feature Name'),
                        'default' => 'Feature 1',
                    ],
                    [
                        'name'    => 'p1',
                        'type'    => 'toggle',
                        'label'   => __('Included in Plan 1'),
                        'default' => true,
                    ],
                    [
                        'name'    => 'p2',
                        'type'    => 'toggle',
                        'label'   => __('Included in Plan 2'),
                        'default' => true,
                    ],
                    [
                        'name'    => 'p3',
                        'type'    => 'toggle',
                        'label'   => __('Included in Plan 3'),
                        'default' => false,
                    ],
                ],
                'default' => [
                    [
                        'name' => __('Core Features'),
                        'p1' => true,
                        'p2' => true,
                        'p3' => true,
                    ],
                    [
                        'name' => __('Advanced Analytics'),
                        'p1' => false,
                        'p2' => true,
                        'p3' => true,
                    ],
                    [
                        'name' => __('Priority Support'),
                        'p1' => false,
                        'p2' => false,
                        'p3' => true,
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'ct_' . substr(md5(uniqid('', true)), 0, 8);

        return view('spotlight::widgets.comparison-table', compact('settings', 'uid'))->render();
    }
}