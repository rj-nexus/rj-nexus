<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class MusicPlayerWidget extends BaseWidget
{
    public function id(): string
    {
        return 'music-player';
    }

    public function name(): string
    {
        return __('Music Player');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13M6 21a3 3 0 100-6 3 3 0 000 6zm12-2a3 3 0 100-6 3 3 0 000 6z"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('A multi-source music player with audio visualizer. Supports Audius, Jamendo, Deezer, local files and custom URLs.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Now Playing'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'source',
                'type'    => 'select',
                'label'   => __('Music Source'),
                'default' => 'audius',
                'tab'     => 'content',
                'options' => [
                    'audius'   => __('Audius (Free, no key)'),
                    'jamendo'  => __('Jamendo (Free client_id)'),
                    'deezer'   => __('Deezer (30s previews)'),
                    'local'    => __('Local Files'),
                    'custom'   => __('Custom URLs'),
                ],
                'help'    => __('Choose where the playlist is loaded from. You can still add local/URL tracks via the repeater fields below.'),
            ],
            [
                'name'    => 'jamendo_client_id',
                'type'    => 'text',
                'label'   => __('Jamendo Client ID'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Required only for Jamendo. Get it free at devportal.jamendo.com.'),
                'help_link' => 'https://devportal.jamendo.com/',
                'help_link_text' => __('Get Client ID →'),
            ],
            [
                'name'    => 'audius_playlist_id',
                'type'    => 'text',
                'label'   => __('Audius Playlist ID (optional)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Leave empty to load trending tracks. Example: D7KyD'),
            ],
            [
                'name'    => 'deezer_playlist_id',
                'type'    => 'text',
                'label'   => __('Deezer Playlist ID (optional)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Leave empty to load charts. Example: 908622995'),
            ],
            [
                'name'    => 'visualizer',
                'type'    => 'select',
                'label'   => __('Visualizer Style'),
                'default' => 'bars',
                'tab'     => 'style',
                'options' => [
                    'bars'     => __('Frequency Bars'),
                    'circular' => __('Circular Wave'),
                    'wave'     => __('Waveform Line'),
                    'none'     => __('None'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent2',
                'type'    => 'color',
                'label'   => __('Gradient End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'height',
                'type'    => 'range',
                'label'   => __('Player Height (px)'),
                'default' => 220,
                'min'     => 120,
                'max'     => 400,
                'step'    => 10,
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'xl'   => __('Large'),
                    '2xl'  => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'show_playlist',
                'type'    => 'toggle',
                'label'   => __('Show Playlist Sidebar'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'autoplay',
                'type'    => 'toggle',
                'label'   => __('Autoplay First Track'),
                'default' => false,
                'tab'     => 'style',
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 60,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'    => 'local_files',
                'type'    => 'repeater',
                'label'   => __('Local / Custom Tracks'),
                'tab'     => 'content',
                'help'    => __('These tracks are always merged with the selected source.'),
                'fields'  => [
                    ['name' => 'file',   'type' => 'media', 'label' => __('Audio File')],
                    ['name' => 'url',    'type' => 'text',  'label' => __('Or Audio URL')],
                    ['name' => 'title',  'type' => 'text',  'label' => __('Title')],
                    ['name' => 'artist', 'type' => 'text',  'label' => __('Artist')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'mp_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.music-player', compact('settings', 'uid'))->render();
    }
}
