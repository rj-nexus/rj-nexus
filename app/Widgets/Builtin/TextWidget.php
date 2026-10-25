<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class TeamWidget extends BaseWidget
{
    private const MAX_MEMBERS = 60;

    /** Inline brand glyphs (24x24, filled). */
    private const PATHS = [
        'facebook' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
        'x' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
        'linkedin' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
        'github' => 'M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12',
        'youtube' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
        'telegram' => 'M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z',
        'tiktok' => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z',
    ];

    /** Drawn with primitives (no long brand path needed). */
    private const SHAPES = [
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.4" cy="6.6" r="1.2" fill="currentColor"/>',
        'rednote' => '<rect x="2.5" y="2.5" width="19" height="19" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><text x="12" y="15.4" text-anchor="middle" font-family="Arial,Helvetica,sans-serif" font-size="8.6" font-weight="800" fill="currentColor">red</text>',
        'website' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.6 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>',
        'email' => '<rect x="3" y="5" width="18" height="14" rx="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M4 8l8 6 8-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'phone' => '<path d="M6.6 3h3l1.5 4.2-2 1.4a11 11 0 0 0 5.3 5.3l1.4-2L21 13.4v3a2.6 2.6 0 0 1-2.8 2.6C10.7 18.500 5 12.800 4 5.800A2.600 2.600 0 0 1 6.600 3z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>',
    ];

    /** Icons that come from the project's rj_icon() (Phosphor set). */
    private const PH = [
        'whatsapp' => 'ph:whatsapp-logo',
        'discord' => 'ph:discord-logo',
        'reddit' => 'ph:reddit-logo',
        'pinterest' => 'ph:pinterest-logo',
        'snapchat' => 'ph:snapchat-logo',
        'twitch' => 'ph:twitch-logo',
        'threads' => 'ph:threads-logo',
        'behance' => 'ph:behance-logo',
        'dribbble' => 'ph:dribbble-logo',
        'medium' => 'ph:medium-logo',
        'spotify' => 'ph:spotify-logo',
        'gitlab' => 'ph:gitlab-logo',
        'stackoverflow' => 'ph:stack-overflow-logo',
        'vimeo' => 'ph:vimeo-logo',
    ];

    private const COLORS = [
        'facebook' => '#1877f2', 'x' => '#000000', 'linkedin' => '#0a66c2', 'instagram' => '#e4405f',
        'tiktok' => '#000000', 'rednote' => '#ff2442', 'github' => '#181717', 'gitlab' => '#fc6d26',
        'youtube' => '#ff0000', 'telegram' => '#26a5e4', 'whatsapp' => '#25d366', 'discord' => '#5865f2',
        'reddit' => '#ff4500', 'pinterest' => '#e60023', 'snapchat' => '#fffc00', 'twitch' => '#9146ff',
        'threads' => '#000000', 'behance' => '#1769ff', 'dribbble' => '#ea4c89', 'medium' => '#000000',
        'spotify' => '#1db954', 'stackoverflow' => '#f48024', 'vimeo' => '#1ab7ea',
        'website' => '#6366f1', 'email' => '#ef4444', 'phone' => '#10b981',
    ];

    private const LABELS = [
        'facebook' => 'Facebook', 'x' => 'X', 'linkedin' => 'LinkedIn', 'instagram' => 'Instagram',
        'tiktok' => 'TikTok', 'rednote' => 'RedNote', 'github' => 'GitHub', 'gitlab' => 'GitLab',
        'youtube' => 'YouTube', 'telegram' => 'Telegram', 'whatsapp' => 'WhatsApp', 'discord' => 'Discord',
        'reddit' => 'Reddit', 'pinterest' => 'Pinterest', 'snapchat' => 'Snapchat', 'twitch' => 'Twitch',
        'threads' => 'Threads', 'behance' => 'Behance', 'dribbble' => 'Dribbble', 'medium' => 'Medium',
        'spotify' => 'Spotify', 'stackoverflow' => 'Stack Overflow', 'vimeo' => 'Vimeo',
        'website' => 'Website', 'email' => 'Email', 'phone' => 'Phone',
    ];

    private const HOSTS = [
        'facebook.com' => 'facebook', 'fb.com' => 'facebook', 'fb.me' => 'facebook',
        'twitter.com' => 'x', 'x.com' => 'x',
        'linkedin.com' => 'linkedin', 'lnkd.in' => 'linkedin',
        'instagram.com' => 'instagram', 'instagr.am' => 'instagram',
        'tiktok.com' => 'tiktok',
        'xiaohongshu.com' => 'rednote', 'xhslink.com' => 'rednote', 'rednote.com' => 'rednote',
        'github.com' => 'github', 'gitlab.com' => 'gitlab',
        'youtube.com' => 'youtube', 'youtu.be' => 'youtube',
        't.me' => 'telegram', 'telegram.me' => 'telegram', 'telegram.org' => 'telegram',
        'wa.me' => 'whatsapp', 'whatsapp.com' => 'whatsapp',
        'discord.gg' => 'discord', 'discord.com' => 'discord',
        'reddit.com' => 'reddit', 'pinterest.com' => 'pinterest', 'pin.it' => 'pinterest',
        'snapchat.com' => 'snapchat', 'twitch.tv' => 'twitch',
        'threads.net' => 'threads', 'threads.com' => 'threads',
        'behance.net' => 'behance', 'dribbble.com' => 'dribbble', 'medium.com' => 'medium',
        'spotify.com' => 'spotify', 'stackoverflow.com' => 'stackoverflow', 'vimeo.com' => 'vimeo',
    ];

    public function id(): string
    {
        return 'team';
    }

    public function name(): string
    {
        return __('Team Members');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Team cards with auto-detected social icons (Instagram, TikTok, RedNote, GitHub and 20+ more).');
    }

    public function schema(): array
    {
        $schema = [
            ['name' => 'section_title', 'type' => 'text', 'label' => __('Section Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 'section_subtitle', 'type' => 'text', 'label' => __('Subtitle'), 'default' => '', 'tab' => 'content'],
            [
                'name' => 'initial_show',
                'type' => 'number',
                'label' => __('Initially Show (Number)'),
                'default' => 4,
                'tab' => 'content',
                'help' => __('How many members to show before the "Show More" button appears. 0 = show all.'),
            ],
            ['name' => 'more_btn_text', 'type' => 'text', 'label' => __('Show More Button Text'), 'default' => __('Show More'), 'tab' => 'content'],
            ['name' => 'less_btn_text', 'type' => 'text', 'label' => __('Show Less Button Text'), 'default' => __('Show Less'), 'tab' => 'content'],
        ];

        for ($i = 1; $i <= 8; $i++) {
            $schema[] = ['name' => 'm' . $i . '_image', 'type' => 'media', 'label' => __('Member ' . $i . ' - Image'), 'default' => '', 'tab' => 'content'];
            $schema[] = ['name' => 'm' . $i . '_name', 'type' => 'text', 'label' => __('Member ' . $i . ' - Name'), 'default' => $i === 1 ? __('John Doe') : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm' . $i . '_position', 'type' => 'text', 'label' => __('Member ' . $i . ' - Position'), 'default' => $i === 1 ? __('CEO & Founder') : '', 'tab' => 'content'];
            $schema[] = [
                'name' => 'm' . $i . '_socials',
                'type' => 'textarea',
                'label' => __('Member ' . $i . ' - Social Links'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => "https://instagram.com/john\nhttps://github.com/john\nhttps://www.xiaohongshu.com/user/profile/...\nmailto:john@site.com",
                'help' => $i === 1 ? __('One link per line. The network is detected from the domain. To force one: "discord | https://..."') : '',
            ];
            $schema[] = ['name' => 'm' . $i . '_facebook', 'type' => 'text', 'label' => __('Member ' . $i . ' - Facebook URL (legacy)'), 'default' => '', 'tab' => 'content'];
            $schema[] = ['name' => 'm' . $i . '_twitter', 'type' => 'text', 'label' => __('Member ' . $i . ' - Twitter/X URL (legacy)'), 'default' => '', 'tab' => 'content'];
            $schema[] = ['name' => 'm' . $i . '_linkedin', 'type' => 'text', 'label' => __('Member ' . $i . ' - LinkedIn URL (legacy)'), 'default' => '', 'tab' => 'content'];
            $schema[] = ['name' => 'm' . $i . '_btn_text', 'type' => 'text', 'label' => __('Member ' . $i . ' - Button Text'), 'default' => $i === 1 ? __('View Profile') : '', 'tab' => 'content'];
            $schema[] = ['name' => 'm' . $i . '_btn_url', 'type' => 'text', 'label' => __('Member ' . $i . ' - Button URL'), 'default' => $i === 1 ? '#' : '', 'tab' => 'content'];
        }

        $schema[] = [
            'name' => 'extra_members',
            'type' => 'textarea',
            'label' => __('Extra Members'),
            'default' => '',
            'tab' => 'content',
            'placeholder' => "Jane Smith | Designer | https://site.com/jane.jpg\nhttps://instagram.com/jane\nhttps://dribbble.com/jane\nbutton: View Profile | /team/jane\n---\nAli Aliyev | Developer\nhttps://github.com/ali",
            'help' => __('Up to 60 members in total. First line: "Name | Position | image URL" (position and image optional). Next lines: social links, and optionally "button: Text | url". Separate members with a line containing only ---'),
        ];

        $schema[] = ['name' => 'columns', 'type' => 'select', 'label' => __('Columns'), 'default' => '3', 'tab' => 'style', 'options' => ['2' => __('2 Columns'), '3' => __('3 Columns'), '4' => __('4 Columns')]];
        $schema[] = ['name' => 'style', 'type' => 'select', 'label' => __('Card Style'), 'default' => 'light', 'tab' => 'style', 'options' => ['light' => __('Light Theme'), 'dark' => __('Dark Theme')]];
        $schema[] = ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#6366f1', 'tab' => 'style'];
        $schema[] = ['name' => 'brand_colors', 'type' => 'toggle', 'label' => __('Brand Colors on Icon Hover'), 'default' => true, 'tab' => 'style'];

        return $schema;
    }

    public function render(array $settings): string
    {
        $members = [];

        for ($i = 1; $i <= 8; $i++) {
            $name = trim((string) ($settings['m' . $i . '_name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $raw = (string) ($settings['m' . $i . '_socials'] ?? '');
            foreach (['facebook', 'twitter', 'linkedin'] as $legacy) {
                $v = trim((string) ($settings['m' . $i . '_' . $legacy] ?? ''));
                if ($v !== '' && $v !== '#') {
                    $raw .= "\n" . ($legacy === 'twitter' ? 'x' : $legacy) . ' | ' . $v;
                }
            }

            $members[] = [
                'image' => trim((string) ($settings['m' . $i . '_image'] ?? '')),
                'name' => $name,
                'position' => trim((string) ($settings['m' . $i . '_position'] ?? '')),
                'socials' => $this->parseSocials($raw),
                'btn_text' => trim((string) ($settings['m' . $i . '_btn_text'] ?? '')),
                'btn_url' => $this->safeUrl((string) ($settings['m' . $i . '_btn_url'] ?? '')),
            ];
        }

        foreach ($this->parseExtra((string) ($settings['extra_members'] ?? '')) as $extra) {
            $members[] = $extra;
        }

        $members = array_slice($members, 0, self::MAX_MEMBERS);

        if (empty($members)) {
            return '';
        }

        $initial = max(0, min(self::MAX_MEMBERS, (int) ($settings['initial_show'] ?? 4)));
        if ($initial === 0 || $initial >= count($members)) {
            $initial = count($members);
        }

        $opts = [
            'title' => trim((string) ($settings['section_title'] ?? '')),
            'subtitle' => trim((string) ($settings['section_subtitle'] ?? '')),
            'cols' => $this->pick($settings['columns'] ?? '3', ['2', '3', '4'], '3'),
            'style' => $this->pick($settings['style'] ?? 'light', ['light', 'dark'], 'light'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#6366f1'),
            'brand' => $this->toBool($settings['brand_colors'] ?? null, true),
            'initial' => $initial,
            'more' => trim((string) ($settings['more_btn_text'] ?? '')) ?: __('Show More'),
            'less' => trim((string) ($settings['less_btn_text'] ?? '')) ?: __('Show Less'),
        ];

        $uid = 'team_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.team', compact('members', 'opts', 'uid'))->render();
    }

    // ---------------------------------------------------------------- socials

    private function parseSocials(string $raw): array
    {
        $out = [];
        $seen = [];

        foreach (preg_split('/\R/u', $raw) ?: [] as $line) {
            $line = trim($line);
            if ($line === '' || $line === '#') {
                continue;
            }

            $key = '';
            if (preg_match('/^([a-z0-9_-]+)\s*\|\s*(.+)$/i', $line, $m)) {
                $cand = strtolower($m[1]);
                $cand = $cand === 'twitter' ? 'x' : ($cand === 'xiaohongshu' ? 'rednote' : $cand);
                if (isset(self::LABELS[$cand])) {
                    $key = $cand;
                    $line = trim($m[2]);
                }
            }

            $url = $this->socialUrl($line);
            if ($url === '') {
                continue;
            }

            if ($key === '') {
                $key = $this->detect($url);
            }

            $sig = $key . '|' . $url;
            if (isset($seen[$sig])) {
                continue;
            }
            $seen[$sig] = true;

            $out[] = [
                'key' => $key,
                'url' => $url,
                'label' => self::LABELS[$key] ?? 'Link',
                'color' => self::COLORS[$key] ?? '#6366f1',
                'svg' => $this->iconHtml($key),
                'external' => !preg_match('/^(mailto|tel):/i', $url),
            ];
        }

        return $out;
    }

    private function detect(string $url): string
    {
        if (stripos($url, 'mailto:') === 0) {
            return 'email';
        }
        if (stripos($url, 'tel:') === 0) {
            return 'phone';
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $host = preg_replace('/^(www|m|mobile|web)\./', '', $host) ?? $host;

        foreach (self::HOSTS as $domain => $key) {
            if ($host === $domain || str_ends_with($host, '.' . $domain)) {
                return $key;
            }
        }

        return 'website';
    }

    private function iconHtml(string $key): string
    {
        if (isset(self::PATHS[$key])) {
            return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="' . self::PATHS[$key] . '"/></svg>';
        }

        if (isset(self::SHAPES[$key])) {
            return '<svg viewBox="0 0 24 24" aria-hidden="true">' . self::SHAPES[$key] . '</svg>';
        }

        if (isset(self::PH[$key]) && function_exists('rj_icon')) {
            $html = (string) rj_icon(self::PH[$key], 'w-5 h-5');
            if (trim($html) !== '') {
                return $html;
            }
        }

        return '<svg viewBox="0 0 24 24" aria-hidden="true">' . self::SHAPES['website'] . '</svg>';
    }

    private function socialUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '' || $url === '#' || $url[0] === '@') {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '';
        }

        if (str_starts_with($url, '//')) {
            return 'https:' . $url;
        }

        if (preg_match('/^[a-z0-9][a-z0-9.\-]*\.[a-z]{2,}(\/.*)?$/i', $url)) {
            return 'https://' . $url;
        }

        return '';
    }

    // ----------------------------------------------------------------- extras

    private function parseExtra(string $raw): array
    {
        $raw = trim($raw);
        if ($raw === '') {
            return [];
        }

        $out = [];

        foreach (preg_split('/\R\s*---\s*\R/u', $raw) ?: [] as $block) {
            $lines = preg_split('/\R/u', trim($block)) ?: [];
            $head = array_map('trim', explode('|', (string) array_shift($lines)));
            $name = $head[0] ?? '';

            if ($name === '' || $name === '---') {
                continue;
            }

            $btnText = '';
            $btnUrl = '';
            $socials = [];

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }
                if (preg_match('/^button\s*:\s*(.+?)\s*\|\s*(\S+)$/i', $line, $m)) {
                    $btnText = $m[1];
                    $btnUrl = $this->safeUrl($m[2]);
                    continue;
                }
                $socials[] = $line;
            }

            $out[] = [
                'image' => $head[2] ?? '',
                'name' => $name,
                'position' => $head[1] ?? '',
                'socials' => $this->parseSocials(implode("\n", $socials)),
                'btn_text' => $btnText,
                'btn_url' => $btnUrl,
            ];
        }

        return $out;
    }

    // ---------------------------------------------------------------- helpers

    private function safeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '';
        }

        return $url;
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function toBool(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    private function hex(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }
}
