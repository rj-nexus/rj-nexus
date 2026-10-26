<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class SocialIconsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'social-icons';
    }

    public function name(): string
    {
        return __('Social Icons');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A grid of interactive social media icons with hover effects.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'layout',
                'type' => 'select',
                'label' => __('Layout'),
                'default' => 'horizontal',
                'tab' => 'style',
                'options' => [
                    'horizontal' => __('Horizontal Row'),
                    'grid' => __('Grid'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'icon_size',
                'type' => 'select',
                'label' => __('Icon Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name' => 'shape',
                'type' => 'select',
                'label' => __('Icon Shape'),
                'default' => 'circle',
                'tab' => 'style',
                'options' => [
                    'circle' => __('Circle'),
                    'square' => __('Rounded Square'),
                    'none' => __('Transparent'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'brand',
                'tab' => 'style',
                'options' => [
                    'brand' => __('Brand Color on Hover'),
                    'monochrome' => __('Monochrome (Black/White)'),
                    'colored' => __('Always Colored'),
                ],
            ],
            [
                'name' => 'links',
                'type' => 'textarea',
                'label' => __('Social Links'),
                'default' => "facebook | https://facebook.com/yourpage\ninstagram | https://instagram.com/yourpage\ntwitter | https://twitter.com/yourpage\nlinkedin | https://linkedin.com/company/yourpage\nyoutube | https://youtube.com/yourchannel\ntiktok | https://tiktok.com/@yourpage\ngithub | https://github.com/yourpage\ntelegram | https://t.me/yourpage\nwhatsapp | https://wa.me/1234567890\ndehliz | https://dehliz.app/yourpage\npiokio | https://piokio.com/yourpage",
                'tab' => 'content',
                'help' => __('One per line: icon_name | url. Available icons: facebook, instagram, twitter, linkedin, youtube, tiktok, github, telegram, whatsapp, dehliz, piokio, cayvoy, kofe.al'),
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'social_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.social-icons', compact('settings', 'uid'))->render();
    }
}
