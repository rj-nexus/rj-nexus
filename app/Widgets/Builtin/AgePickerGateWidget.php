<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

/**
 * Yaş seçimi qapısı. Ziyarətçi slider ilə yaşını seçir (0-65+),
 * yuxarıdakı personaj yaşa görə böyüyüb qocalır və daim hərəkətdədir.
 * Minimum yaşdan azdırsa sayt açılmır.
 *
 * Diqqət: bu özünü-bəyan (self-declared) yaş təsdiqidir, hüquqi KYC deyil.
 */
class AgePickerGateWidget extends BaseWidget
{
    public function id(): string
    {
        return 'age-picker-gate';
    }

    public function name(): string
    {
        return __('Age Picker Gate');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="7" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-3a6 6 0 0112 0v3M4 12h2m12 0h2"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Visitor picks their age (0-65+) with a slider. An animated character above grows up and ages with the slider. Under the minimum age the site stays closed.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'enabled', 'type' => 'toggle', 'label' => __('Enabled'), 'default' => true, 'tab' => 'content'],
            [
                'name' => 'mode',
                'type' => 'select',
                'label' => __('Display Mode'),
                'default' => 'overlay',
                'tab' => 'content',
                'options' => ['overlay' => __('Full-screen overlay'), 'inline' => __('Inline preview (for editing)')],
                'help' => __('Use Inline while designing so the overlay does not block the editor, then switch to Full-screen.'),
            ],
            [
                'name' => 'min_age',
                'type' => 'select',
                'label' => __('Minimum Age'),
                'default' => '18',
                'tab' => 'content',
                'options' => $this->ageOptions(),
                'help' => __('Visitors younger than this cannot continue.'),
            ],
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('How old are you?'), 'tab' => 'content'],
            ['name' => 'text', 'type' => 'text', 'label' => __('Description'), 'default' => __('Move the slider to your age. You must be {age} or older to enter.'), 'tab' => 'content', 'help' => __('{age} is replaced with the minimum age.')],
            ['name' => 'verify_label', 'type' => 'text', 'label' => __('Continue Button'), 'default' => __('Continue'), 'tab' => 'content'],
            ['name' => 'deny_title', 'type' => 'text', 'label' => __('Access Denied Title'), 'default' => __('Access denied'), 'tab' => 'content'],
            ['name' => 'deny_text', 'type' => 'text', 'label' => __('Access Denied Text'), 'default' => __('You must be {age} or older to enter this site.'), 'tab' => 'content'],
            ['name' => 'deny_url', 'type' => 'text', 'label' => __('Redirect When Denied (optional)'), 'default' => '', 'tab' => 'content', 'placeholder' => 'https://www.google.com', 'help' => __('Leave empty to only show the denied message.')],
            [
                'name' => 'remember_days',
                'type' => 'select',
                'label' => __('Remember Answer'),
                'default' => '30',
                'tab' => 'content',
                'options' => ['0' => __('Until browser closes'), '1' => '1 ' . __('day'), '7' => '7 ' . __('days'), '30' => '30 ' . __('days'), '365' => '365 ' . __('days')],
            ],
            ['name' => 'skip_bots', 'type' => 'toggle', 'label' => __('Do Not Show to Search Bots'), 'default' => true, 'tab' => 'content', 'help' => __('Lets search engines index the page content.')],

            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'glass',
                'tab' => 'style',
                'options' => ['glass' => __('Glass'), 'glass-dark' => __('Glass (Dark)')],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
            [
                'name' => 'stars',
                'type' => 'select',
                'label' => __('Star Density'),
                'default' => 'medium',
                'tab' => 'style',
                'options' => ['low' => __('Low'), 'medium' => __('Medium'), 'high' => __('High')],
            ],
            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Animations'), 'default' => true, 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        if (!$this->flag($settings['enabled'] ?? null, true)) {
            return '';
        }

        $mode = $this->pick($settings['mode'] ?? 'overlay', ['overlay', 'inline'], 'overlay');

        if ($mode === 'overlay' && $this->flag($settings['skip_bots'] ?? null, true) && $this->isBot()) {
            return '';
        }

        $age = (int) $this->pick($settings['min_age'] ?? '18', array_map('strval', range(3, 65)), '18');
        $rep = fn (string $s): string => str_replace('{age}', (string) $age, $s);
        $denyUrl = trim((string) ($settings['deny_url'] ?? ''));

        $opts = [
            'mode' => $mode,
            'age' => $age,
            'title' => $rep($this->text($settings['title'] ?? '', 120)),
            'text' => $rep($this->text($settings['text'] ?? '', 240)),
            'verify' => $rep($this->text($settings['verify_label'] ?? '', 60)),
            'deny_title' => $rep($this->text($settings['deny_title'] ?? '', 120)),
            'deny_text' => $rep($this->text($settings['deny_text'] ?? '', 240)),
            'style' => $this->pick($settings['style'] ?? 'glass', ['glass', 'glass-dark'], 'glass'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#8b5cf6'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
        ];

        $labels = [
            'verifying' => __('Verifying your age'),
            'verified' => __('Verified. Welcome, traveler!'),
            'below' => __('This age is below the minimum.'),
            'age' => __('Age'),
            'stages' => [
                __('Baby'), __('Child'), __('Teen'), __('Young adult'),
                __('Adult'), __('Senior'), __('Wise elder'),
            ],
        ];

        $payload = [
            'age' => $age,
            'maxAge' => 65,
            'mode' => $mode,
            'remember' => (int) $this->pick($settings['remember_days'] ?? '30', ['0', '1', '7', '30', '365'], '30'),
            'denyUrl' => $denyUrl !== '' ? $this->safeUrl($denyUrl) : '',
            'stars' => $this->pick($settings['stars'] ?? 'medium', ['low', 'medium', 'high'], 'medium'),
            'anim' => $opts['animate'],
            'labels' => $labels,
        ];

        return view('rjbuilder.widgets.builtin.age-picker-gate', [
            'o' => $opts,
            'uid' => 'ap_' . substr(md5(uniqid('', true)), 0, 8),
            'payload' => $payload,
            'labels' => $labels,
        ])->render();
    }

    private function ageOptions(): array
    {
        $out = [];
        foreach (range(3, 65) as $a) {
            $out[(string) $a] = $a . '+';
        }

        return $out;
    }

    private function isBot(): bool
    {
        $ua = (string) request()->userAgent();

        return $ua !== '' && preg_match('/bot|crawl|spider|slurp|mediapartners|facebookexternalhit|embedly|pinterest|lighthouse|pagespeed|headlesschrome/i', $ua) === 1;
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim(strip_tags((string) $value)), 0, $max);
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') { return ''; }
        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^https?:/i', $url) ? $url : '';
        }
        return $url;
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function flag(mixed $value, bool $default): bool
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