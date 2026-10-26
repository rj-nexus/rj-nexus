<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class SoundCloudWidget extends BaseWidget
{
    public function id(): string
    {
        return 'soundcloud';
    }

    public function name(): string
    {
        return __('SoundCloud');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('Embed SoundCloud tracks or playlists with customizable player styles.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'url',
                'type' => 'text',
                'label' => __('SoundCloud URL'),
                'default' => 'https://soundcloud.com/officialmusic/example',
                'tab' => 'content',
                'help' => __('Paste the URL of the track or playlist you want to embed.'),
            ],
            [
                'name' => 'color',
                'type' => 'color',
                'label' => __('Player Accent Color'),
                'default' => '#ff5500',
                'tab' => 'style',
            ],
            [
                'name' => 'visual',
                'type' => 'toggle',
                'label' => __('Show Artwork (Visual Mode)'),
                'default' => true,
                'tab' => 'style',
            ],
            [
                'name' => 'autoplay',
                'type' => 'toggle',
                'label' => __('Autoplay'),
                'default' => false,
                'tab' => 'style',
            ],
            [
                'name' => 'hide_related',
                'type' => 'toggle',
                'label' => __('Hide Related Tracks'),
                'default' => false,
                'tab' => 'style',
            ],
            [
                'name' => 'show_comments',
                'type' => 'toggle',
                'label' => __('Show Comments'),
                'default' => true,
                'tab' => 'style',
            ],
            [
                'name' => 'show_user',
                'type' => 'toggle',
                'label' => __('Show Uploader Name'),
                'default' => true,
                'tab' => 'style',
            ],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Player Height'),
                'default' => '166',
                'tab' => 'style',
                'options' => [
                    '166' => __('Standard (166px)'),
                    '300' => __('Medium (300px)'),
                    '450' => __('Large / Playlist (450px)'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'sc_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.soundcloud', compact('settings', 'uid'))->render();
    }
}
