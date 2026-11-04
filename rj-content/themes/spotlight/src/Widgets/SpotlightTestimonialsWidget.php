<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightTestimonialsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-testimonials';
    }

    public function name(): string
    {
        return __('Spotlight Testimonials');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A 6-card testimonial marquee with a rotating background globe.');
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
                'default' => '[ 07 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ TESTIMONIALS ]',
            ],
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => '||| REAL FEEDBACK FROM CREATORS AND POWER USERS. |||',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Main Title'),
                'default' => 'What people say about RJ Nexus.',
            ],
            [
                'name' => 'testimonials',
                'type' => 'repeater',
                'label' => __('Testimonials (Max 6)'),
                'max_items' => 6,
                'default' => [
                    [
                        'name' => 'Ethan Moore',
                        'username' => '@ethanmoore',
                        'text' => 'Started with the free plan on @rjnexus and didn\'t expect much. But the speed, accuracy, and clean UI convinced me to upgrade in just a few days.',
                        'image' => '',
                    ],
                    [
                        'name' => 'Sarah Chen',
                        'username' => '@sarahchen',
                        'text' => '@rjnexus helps me organize creative tasks way faster. The image prompt support is smooth and the AI responses feel human.',
                        'image' => '',
                    ],
                    [
                        'name' => 'Olivia Tran',
                        'username' => '@oliviatran',
                        'text' => 'As a marketer, I rely on @rjnexus daily. It cuts the noise and delivers clear, brand-friendly copy every time.',
                        'image' => '',
                    ],
                    [
                        'name' => 'Lucas Bennett',
                        'username' => '@lucasbennett',
                        'text' => '@rjnexus helps me organize creative tasks way faster. The image prompt support is smooth and the AI responses feel human.',
                        'image' => '',
                    ],
                    [
                        'name' => 'James Wilson',
                        'username' => '@jameswilson',
                        'text' => '@rjnexus helps me organize creative tasks way faster. The image prompt support is smooth and the AI responses feel human.',
                        'image' => '',
                    ],
                    [
                        'name' => 'Elena Rossi',
                        'username' => '@elenarossi',
                        'text' => 'I use @rjnexus to generate ideas for my startup. The prompts are clean and the output is ready to use.',
                        'image' => '',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => __('Name'),
                        'default' => 'John Doe',
                    ],
                    [
                        'name' => 'username',
                        'type' => 'text',
                        'label' => __('Username / Handle'),
                        'default' => '@johndoe',
                    ],
                    [
                        'name' => 'text',
                        'type' => 'textarea',
                        'label' => __('Testimonial Text'),
                        'default' => 'This is an amazing platform!',
                    ],
                    [
                        'name' => 'image',
                        'type' => 'media',
                        'label' => __('Avatar Image'),
                        'default' => '',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-testimonials', compact('settings'))->render();
    }
}
