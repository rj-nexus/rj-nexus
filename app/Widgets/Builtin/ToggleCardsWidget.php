<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ToggleCardsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'toggle-cards';
    }

    public function name(): string
    {
        return __('Toggle Cards');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A grid of cards that can be clicked to expand and reveal hidden content.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'columns',
                'type' => 'select',
                'label' => __('Columns'),
                'default' => '3',
                'tab' => 'style',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Card Style'),
                'default' => 'light',
                'tab' => 'style',
                'options' => [
                    'light' => __('Light Shadow'),
                    'bordered' => __('Bordered'),
                    'dark' => __('Dark Theme'),
                ],
            ],
            [
                'name' => 'accent_color',
                'type' => 'color',
                'label' => __('Icon Accent Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],

            // Card 1
            ['name' => 'c1_icon', 'type' => 'icon', 'label' => __('Card 1 - Icon'), 'default' => 'ph:sparkle', 'tab' => 'content'],
            ['name' => 'c1_title', 'type' => 'text', 'label' => __('Card 1 - Title'), 'default' => __('Premium Quality'), 'tab' => 'content'],
            ['name' => 'c1_excerpt', 'type' => 'text', 'label' => __('Card 1 - Short Excerpt'), 'default' => __('Crafted with the finest materials.'), 'tab' => 'content'],
            ['name' => 'c1_content', 'type' => 'textarea', 'label' => __('Card 1 - Expanded Content'), 'default' => __('Our products are meticulously designed and manufactured using only the highest grade materials to ensure longevity and unparalleled quality.'), 'tab' => 'content'],

            // Card 2
            ['name' => 'c2_icon', 'type' => 'icon', 'label' => __('Card 2 - Icon'), 'default' => 'ph:truck', 'tab' => 'content'],
            ['name' => 'c2_title', 'type' => 'text', 'label' => __('Card 2 - Title'), 'default' => __('Fast Shipping'), 'tab' => 'content'],
            ['name' => 'c2_excerpt', 'type' => 'text', 'label' => __('Card 2 - Short Excerpt'), 'default' => __('Delivered to your door in days.'), 'tab' => 'content'],
            ['name' => 'c2_content', 'type' => 'textarea', 'label' => __('Card 2 - Expanded Content'), 'default' => __('We offer express shipping options worldwide, ensuring your order reaches you as quickly as possible, no matter where you are located.'), 'tab' => 'content'],

            // Card 3
            ['name' => 'c3_icon', 'type' => 'icon', 'label' => __('Card 3 - Icon'), 'default' => 'ph:shield-check', 'tab' => 'content'],
            ['name' => 'c3_title', 'type' => 'text', 'label' => __('Card 3 - Title'), 'default' => __('Secure Shopping'), 'tab' => 'content'],
            ['name' => 'c3_excerpt', 'type' => 'text', 'label' => __('Card 3 - Short Excerpt'), 'default' => __('100% safe and encrypted.'), 'tab' => 'content'],
            ['name' => 'c3_content', 'type' => 'textarea', 'label' => __('Card 3 - Expanded Content'), 'default' => __('Your privacy and security are our top priorities. We use industry-standard SSL encryption to protect your personal and payment information.'), 'tab' => 'content'],

            // Card 4
            ['name' => 'c4_icon', 'type' => 'icon', 'label' => __('Card 4 - Icon'), 'default' => '', 'tab' => 'content'],
            ['name' => 'c4_title', 'type' => 'text', 'label' => __('Card 4 - Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 'c4_excerpt', 'type' => 'text', 'label' => __('Card 4 - Short Excerpt'), 'default' => '', 'tab' => 'content'],
            ['name' => 'c4_content', 'type' => 'textarea', 'label' => __('Card 4 - Expanded Content'), 'default' => '', 'tab' => 'content'],
        ];
    }

    public function render(array $settings): string
    {
        $cards = [];
        for ($i = 1; $i <= 4; $i++) {
            if (!empty($settings['c'.$i.'_title'])) {
                $cards[] = [
                    'icon' => $settings['c'.$i.'_icon'] ?? '',
                    'title' => $settings['c'.$i.'_title'],
                    'excerpt' => $settings['c'.$i.'_excerpt'] ?? '',
                    'content' => $settings['c'.$i.'_content'] ?? '',
                ];
            }
        }

        if (empty($cards)) {
            return '';
        }

        $uid = 'tcard_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.toggle-cards', compact('settings', 'cards', 'uid'))->render();
    }
}
