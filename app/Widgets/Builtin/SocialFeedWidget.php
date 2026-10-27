<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class SocialFeedWidget extends BaseWidget
{
    public function id(): string
    {
        return 'social-feed';
    }

    public function name(): string
    {
        return __('Social Feed');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A social feed grid with oEmbed support, RSS auto-feed, and manual posts.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Follow us'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => __('Latest from our social channels'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'enable_oembed',
                'type'    => 'toggle',
                'label'   => __('Enable oEmbed (real post preview)'),
                'default' => true,
                'tab'     => 'content',
                'help'    => __('When a post URL is provided, the real post is fetched via oEmbed. Works for Twitter/X and Instagram without an API key. Unlimited and free.'),
            ],
            [
                'name'           => 'enable_rss',
                'type'           => 'toggle',
                'label'          => __('Enable RSS Auto-Feed'),
                'default'        => false,
                'tab'            => 'content',
                'help'           => __('Automatically pulls posts from an RSS feed. Free rss.app plan allows 2 feeds with max 5 posts each. For more, upgrade on the official site.'),
                'help_link'      => 'https://rss.app/pricing',
                'help_link_text' => __('View pricing →'),
            ],
            [
                'name'           => 'rss_url',
                'type'           => 'text',
                'label'          => __('RSS Feed URL'),
                'default'        => '',
                'tab'            => 'content',
                'help'           => __('Paste an RSS feed URL from rss.app, fetchrss.com or your own generator. Free rss.app plan: 2 feeds × 5 posts. Need more? Upgrade on official site.'),
                'help_link'      => 'https://rss.app',
                'help_link_text' => __('Open rss.app →'),
            ],
            [
                'name'    => 'rss_proxy',
                'type'    => 'select',
                'label'   => __('RSS Proxy'),
                'default' => 'rss2json',
                'tab'     => 'content',
                'options' => [
                    'rss2json' => __('rss2json.com (free)'),
                    'none'     => __('No proxy (CORS may block)'),
                ],
            ],
            [
                'name'    => 'rss_limit',
                'type'    => 'number',
                'label'   => __('RSS Post Limit'),
                'default' => 9,
                'min'     => 1,
                'max'     => 30,
                'step'    => 1,
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'grid',
                'tab'     => 'style',
                'options' => [
                    'grid'    => __('Grid'),
                    'masonry' => __('Masonry'),
                    'carousel'=> __('Carousel'),
                ],
            ],
            [
                'name'    => 'columns',
                'type'    => 'select',
                'label'   => __('Columns'),
                'default' => '3',
                'tab'     => 'style',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                ],
            ],
            [
                'name'    => 'gap',
                'type'    => 'select',
                'label'   => __('Gap'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'aspect',
                'type'    => 'select',
                'label'   => __('Card Ratio'),
                'default' => '1/1',
                'tab'     => 'style',
                'options' => [
                    '1/1'  => __('Square'),
                    '4/3'  => __('Landscape'),
                    '3/4'  => __('Portrait'),
                    '16/9' => __('Wide'),
                ],
            ],
            [
                'name'    => 'show_platform',
                'type'    => 'toggle',
                'label'   => __('Show Platform Icon'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_caption',
                'type'    => 'toggle',
                'label'   => __('Show Caption'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_date',
                'type'    => 'toggle',
                'label'   => __('Show Date'),
                'default' => false,
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'xl'   => __('Extra Large'),
                ],
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
                'name'    => 'show_tabs',
                'type'    => 'toggle',
                'label'   => __('Show Platform Filter Tabs'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'items',
                'type'    => 'repeater',
                'label'   => __('Manual Posts (fallback)'),
                'tab'     => 'content',
                'fields' => [
                    ['name' => 'platform', 'type' => 'select', 'label' => __('Platform'), 'options' => [
                        'twitter'   => 'Twitter / X',
                        'instagram' => 'Instagram',
                        'piokio'    => 'Piokio',
                        'dehliz'    => 'Dehliz',
                        'reax'      => 'Reax',
                    ]],
                    ['name' => 'image',    'type' => 'media', 'label' => __('Image')],
                    ['name' => 'caption',  'type' => 'textarea', 'label' => __('Caption')],
                    ['name' => 'url',      'type' => 'text', 'label' => __('Post URL')],
                    ['name' => 'date',     'type' => 'text', 'label' => __('Date (e.g. 2026-10-27)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'sf_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.social-feed', compact('settings', 'uid'))->render();
    }
}
