<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightPricingWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-pricing';
    }

    public function name(): string
    {
        return __('Spotlight Pricing');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A pricing section with 3 cards, highlighted popular plan, and animated features.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'show_hud',
                'type' => 'toggle',
                'label' => __('Show HUD and Lines'),
                'default' => true,
            ],
            [
                'name' => 'hud_left',
                'type' => 'text',
                'label' => __('HUD Left Text'),
                'default' => '[ 06 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ PRICING ]',
            ],
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Top Badge Text'),
                'default' => '||| PLANS FOR EVERY CREATOR. |||',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'Flexible pricing that scales with you',
            ],
            [
                'name' => 'plans',
                'type' => 'repeater',
                'label' => __('Pricing Plans'),
                'max_items' => 3,
                'default' => [
                    [
                        'is_popular' => false,
                        'plan_name' => 'Free Plan',
                        'price' => '$0',
                        'period' => 'forever',
                        'description' => 'Perfect for testing and light creative needs.',
                        'button_text' => 'Start free trial',
                        'button_url' => '/',
                        'features' => "50 prompts / mo\n10 images / mo (up to 5MB)\n2 videos / mo (720p)\nBasic AI model",
                    ],
                    [
                        'is_popular' => true,
                        'plan_name' => 'Plus Plan',
                        'price' => '$19',
                        'period' => 'per user / mo',
                        'description' => 'Unlock more power with advanced models and bigger limits.',
                        'button_text' => 'Start free trial',
                        'button_url' => '/',
                        'features' => "500 prompts / mo\n100 images / mo (up to 10MB)\n20 videos / mo (1080p)\nWebsite builder (basic)\nBasic AI model",
                    ],
                    [
                        'is_popular' => false,
                        'plan_name' => 'Pro Plan',
                        'price' => '$49',
                        'period' => 'per user / mo',
                        'description' => 'Everything unlimited. For pros, teams, and power creators.',
                        'button_text' => 'Start free trial',
                        'button_url' => '/',
                        'features' => "Unlimited prompts\nUnlimited images (up to 25MB)\n100+ videos / mo (4K)\nWebsite builder (advanced)\nAPI access\nAdvanced AI model",
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'is_popular',
                        'type' => 'toggle',
                        'label' => __('Highlight this plan?'),
                        'default' => false,
                    ],
                    [
                        'name' => 'plan_name',
                        'type' => 'text',
                        'label' => __('Plan Name'),
                        'default' => 'New Plan',
                    ],
                    [
                        'name' => 'price',
                        'type' => 'text',
                        'label' => __('Price'),
                        'default' => '$0',
                    ],
                    [
                        'name' => 'period',
                        'type' => 'text',
                        'label' => __('Period'),
                        'default' => 'per month',
                    ],
                    [
                        'name' => 'description',
                        'type' => 'textarea',
                        'label' => __('Short Description'),
                        'default' => 'Plan description goes here.',
                    ],
                    [
                        'name' => 'button_text',
                        'type' => 'text',
                        'label' => __('Button Text'),
                        'default' => 'Get Started',
                    ],
                    [
                        'name' => 'button_url',
                        'type' => 'text',
                        'label' => __('Button URL'),
                        'default' => '/',
                    ],
                    [
                        'name' => 'features',
                        'type' => 'textarea',
                        'label' => __('Features (One per line)'),
                        'default' => "Feature 1\nFeature 2\nFeature 3",
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-pricing', compact('settings'))->render();
    }
}
