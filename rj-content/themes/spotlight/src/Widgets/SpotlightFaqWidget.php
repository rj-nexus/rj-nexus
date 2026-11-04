<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightFaqWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-faq';
    }

    public function name(): string
    {
        return __('Spotlight FAQ');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('An interactive FAQ accordion with glassmorphism styling and glowing active states.');
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
                'default' => '[ 08 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ FAQS ]',
            ],
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => '||| ANSWERS TO YOUR COMMON QUESTIONS. |||',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => "Got questions?\nWe've got answers.",
            ],
            [
                'name' => 'faqs',
                'type' => 'repeater',
                'label' => __('FAQ Items'),
                'default' => [
                    ['question' => 'What can I use RJ Nexus for?', 'answer' => 'You can generate taglines, short descriptions, ideas for visuals, social posts, and more in seconds.'],
                    ['question' => 'Is RJ Nexus free to use?', 'answer' => 'RJ Nexus offers a free tier with limited generations. Paid plans unlock more features and outputs.'],
                    ['question' => 'Can I use RJ Nexus for commercial projects?', 'answer' => 'Yes — all generated content can be used for both personal and commercial purposes.'],
                    ['question' => 'How accurate are the outputs?', 'answer' => 'Results are context-aware and high quality, but we recommend reviewing and refining for best use.'],
                    ['question' => 'What if I don\'t like the result?', 'answer' => 'You can regenerate as many times as needed, or edit outputs directly to suit your needs.'],
                    ['question' => 'Do you offer support?', 'answer' => 'Yes, our support team is available 24/7 to help you with any issues or questions you might have.'],
                ],
                'fields' => [
                    [
                        'name' => 'question',
                        'type' => 'text',
                        'label' => __('Question'),
                        'default' => 'New Question?',
                    ],
                    [
                        'name' => 'answer',
                        'type' => 'textarea',
                        'label' => __('Answer'),
                        'default' => 'Answer goes here.',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-faq', compact('settings'))->render();
    }
}
