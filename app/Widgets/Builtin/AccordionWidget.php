<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AccordionWidget extends BaseWidget
{
    public function id(): string
    {
        return 'accordion';
    }

    public function name(): string
    {
        return __('Accordion / FAQ');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A collapsible accordion for Frequently Asked Questions.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Section Title'),
                'default' => __('Frequently Asked Questions'),
                'tab' => 'content',
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'bordered',
                'tab' => 'style',
                'options' => [
                    'bordered' => __('Bordered (Minimal)'),
                    'clean' => __('Clean (White Background)'),
                    'dark' => __('Dark Theme'),
                ],
            ],

            // Item 1
            ['name' => 'q1', 'type' => 'text', 'label' => __('Question 1'), 'default' => __('How long does shipping take?'), 'tab' => 'content'],
            ['name' => 'a1', 'type' => 'textarea', 'label' => __('Answer 1'), 'default' => __('Standard shipping usually takes 3-5 business days. Express shipping is available at checkout.'), 'tab' => 'content'],

            // Item 2
            ['name' => 'q2', 'type' => 'text', 'label' => __('Question 2'), 'default' => __('What is your return policy?'), 'tab' => 'content'],
            ['name' => 'a2', 'type' => 'textarea', 'label' => __('Answer 2'), 'default' => __('We offer a 30-day money-back guarantee. If you are not satisfied, you can return the item for a full refund.'), 'tab' => 'content'],

            // Item 3
            ['name' => 'q3', 'type' => 'text', 'label' => __('Question 3'), 'default' => __('Do you ship internationally?'), 'tab' => 'content'],
            ['name' => 'a3', 'type' => 'textarea', 'label' => __('Answer 3'), 'default' => __('Yes, we ship to over 100 countries worldwide. Shipping costs will be calculated at checkout.'), 'tab' => 'content'],

            // Item 4
            ['name' => 'q4', 'type' => 'text', 'label' => __('Question 4'), 'default' => '', 'tab' => 'content'],
            ['name' => 'a4', 'type' => 'textarea', 'label' => __('Answer 4'), 'default' => '', 'tab' => 'content'],
        ];
    }

    public function render(array $settings): string
    {
        $items = [];
        for ($i = 1; $i <= 4; $i++) {
            if (!empty($settings['q'.$i])) {
                $items[] = [
                    'question' => $settings['q'.$i],
                    'answer' => $settings['a'.$i] ?? '',
                ];
            }
        }

        if (empty($items)) {
            return '';
        }

        $uid = 'acc_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.accordion', compact('settings', 'items', 'uid'))->render();
    }
}
