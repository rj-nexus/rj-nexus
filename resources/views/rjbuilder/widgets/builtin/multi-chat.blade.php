@php
    $position       = $settings['position'] ?? 'bottom-right';
    $iconStyle      = $settings['icon_style'] ?? 'brand';
    $accent         = $settings['accent'] ?? '#8b5cf6';
    $size           = $settings['size'] ?? 'md';
    $trigger        = $settings['trigger'] ?? 'click';
    $mainLabel      = $settings['main_label'] ?? __('Contact us');
    $showLabels     = $settings['show_labels'] ?? true;
    $badge          = trim((string) ($settings['badge'] ?? ''));
    $pulse          = $settings['pulse'] ?? true;
    $greeting       = trim((string) ($settings['greeting'] ?? ''));
    $greetingDelay  = (int) ($settings['greeting_delay'] ?? 3);

    $sizeMap = ['sm' => 48, 'md' => 58, 'lg' => 68];
    $sizePx  = $sizeMap[$size] ?? 58;

    $brands = [
        'whatsapp'  => ['label' => 'WhatsApp',  'color' => '#25D366'],
        'telegram'  => ['label' => 'Telegram',  'color' => '#0088cc'],
        'instagram' => ['label' => 'Instagram', 'color' => '#E4405F'],
        'facebook'  => ['label' => 'Facebook',  'color' => '#1877F2'],
        'messenger' => ['label' => 'Messenger', 'color' => '#0084FF'],
        'twitter'   => ['label' => 'X',         'color' => '#000000'],
        'tiktok'    => ['label' => 'TikTok',    'color' => '#000000'],
        'linkedin'  => ['label' => 'LinkedIn',  'color' => '#0A66C2'],
        'youtube'   => ['label' => 'YouTube',   'color' => '#FF0000'],
        'viber'     => ['label' => 'Viber',     'color' => '#7360F2'],
        'skype'     => ['label' => 'Skype',     'color' => '#00AFF0'],
        'discord'   => ['label' => 'Discord',   'color' => '#5865F2'],
        'signal'    => ['label' => 'Signal',    'color' => '#3A76F0'],
        'email'     => ['label' => 'Email',     'color' => '#ea4335'],
        'phone'     => ['label' => 'Call',      'color' => '#16a34a'],
        'sms'       => ['label' => 'SMS',       'color' => '#f59e0b'],
        'website'   => ['label' => 'Website',   'color' => '#6366f1'],
        'custom'    => ['label' => 'Link',      'color' => '#8b5cf6'],
    ];

    $icons = [
        'whatsapp'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.693.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>',
        'telegram'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
        'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'messenger' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.373 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm1.193 14.963l-3.056-3.259-5.963 3.259L10.732 8l3.13 3.259L19.752 8l-6.559 6.963z"/></svg>',
        'twitter'   => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'tiktok'    => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>',
        'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
        'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        'viber'     => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.398.002C8.852.057 5.39.401 3.394 2.222 1.85 3.632.833 6.297.734 9.024c-.219 5.83 3.883 10.963 9.678 11.27h.004c.863.043 1.828-.075 2.474-.352l.797-.344 1.774 1.02c.531.307 1.352.34 1.681.075.26-.21.323-.79.198-1.34l-.51-2.163c1.129-1.352 1.816-3.013 1.977-4.825.164-1.83.118-3.837-.375-5.572-.65-2.29-2.078-3.92-4.34-4.593-1.247-.371-2.586-.518-3.981-.475l-.832.014-.407-.407C12.114.234 11.771.005 11.398.002zM11.7 2.16c.431-.005.862.037 1.283.13 2.005.447 3.24 1.793 3.826 3.882.44 1.566.478 3.4.338 5.03-.139 1.632-.774 3.126-1.81 4.32-.291.336-.35.79-.243 1.243.106.454.25.91.396 1.365-.14.014-.299-.021-.442-.099l-1.985-1.138c-.216-.123-.474-.132-.695-.028-.474.24-1.27.34-2.005.305-4.848-.257-8.271-4.53-8.092-9.352.083-2.303.87-4.484 2.05-5.577C6.732 2.499 9.815 2.24 11.7 2.16zm-1.44 3.6c-.156 0-.33.038-.487.113-.156.075-.34.203-.463.31-.122.106-.21.153-.344.395-.133.243-.34.708-.34 1.357 0 .65.244 1.297.398 1.63.155.333 1.238 1.86 3.121 2.634 1.883.774 2.135.58 2.522.544.386-.037 1.244-.508 1.421-1 .176-.49.176-.913.124-1.001-.052-.088-.192-.14-.398-.244-.207-.104-1.226-.605-1.415-.675-.19-.07-.328-.104-.466.105-.14.21-.535.674-.656.812-.122.14-.243.156-.45.052-.207-.104-.874-.322-1.665-1.027-.615-.548-1.03-1.226-1.152-1.435-.122-.208-.014-.32.09-.423.092-.092.207-.243.31-.363.104-.121.14-.207.21-.346.069-.14.034-.26-.018-.365-.052-.104-.464-1.12-.637-1.533-.167-.402-.34-.348-.467-.354-.12-.005-.26-.006-.399-.006z"/></svg>',
        'skype'     => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.006 0c-1.55 0-3.052.283-4.438.803.354-.06.71-.09 1.07-.09 3.907 0 7.083 3.176 7.083 7.083 0 .36-.03.716-.09 1.07.52-1.386.803-2.888.803-4.438C16.434 2.164 14.43.155 12.006 0zm6.925 3.37c-1.485 0-2.88.527-3.967 1.408.376-.056.76-.084 1.149-.084 3.354 0 6.071 2.717 6.071 6.071 0 .39-.028.773-.084 1.15A6.116 6.116 0 0023.508 8.3c0-2.73-2.212-4.93-4.577-4.93zM9.83 6.849c-2.888 0-5.23 2.343-5.23 5.23 0 1.013.29 1.96.79 2.762-.582.845-.925 1.865-.925 2.966 0 2.888 2.342 5.23 5.23 5.23.703 0 1.374-.14 1.985-.39a5.65 5.65 0 003.245.998c3.123 0 5.65-2.528 5.65-5.65a5.62 5.62 0 00-.998-3.245c.25-.611.39-1.282.39-1.985 0-2.887-2.343-5.23-5.23-5.23a5.19 5.19 0 00-2.966.925 5.19 5.19 0 00-2.762-.79zm4.946 5.406c.362.087.632.354.72.716.088.362-.014.746-.264.996l-2.548 2.548a1.144 1.144 0 01-1.617 0l-1.554-1.554a1.144 1.144 0 011.617-1.617l.746.746 1.74-1.74a1.144 1.144 0 011.16-.095z"/></svg>',
        'discord'   => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>',
        'signal'    => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0zm5.86 17.4h-.005a2.51 2.51 0 01-2.11-1.14 10.02 10.02 0 01-7.49 0 2.51 2.51 0 01-4.62-1.37 2.51 2.51 0 01.535-1.535 10.02 10.02 0 010-6.71A2.51 2.51 0 014.14 4.99a2.51 2.51 0 012.09 1.13 10.02 10.02 0 017.5 0 2.51 2.51 0 014.62 1.37 2.51 2.51 0 01-.53 1.53 10.02 10.02 0 010 6.72 2.51 2.51 0 01.54 1.53 2.51 2.51 0 01-2.5 2.13z"/></svg>',
        'email'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6"/></svg>',
        'phone'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>',
        'sms'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>',
        'website'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
        'custom'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
    ];

    function rj_mc_build_url(string $platform, string $value): string {
        $value = trim($value);
        if ($value === '') return '#';
        $clean = ltrim($value, '@');
        switch ($platform) {
            case 'whatsapp':  return 'https://wa.me/' . preg_replace('/\D+/', '', $value);
            case 'telegram':  return 'https://t.me/' . $clean;
            case 'instagram': return 'https://instagram.com/' . $clean;
            case 'facebook':  return 'https://facebook.com/' . $clean;
            case 'messenger': return 'https://m.me/' . $clean;
            case 'twitter':   return 'https://x.com/' . $clean;
            case 'tiktok':    return 'https://tiktok.com/@' . $clean;
            case 'linkedin':  return 'https://linkedin.com/in/' . $clean;
            case 'youtube':   return 'https://youtube.com/@' . $clean;
            case 'viber':     return 'viber://chat?number=' . urlencode($value);
            case 'skype':     return 'skype:' . $clean . '?chat';
            case 'discord':   return preg_match('#^https?://#i', $value) ? $value : 'https://discord.gg/' . $clean;
            case 'signal':    return 'https://signal.me/#p/' . urlencode($value);
            case 'email':     return 'mailto:' . $value;
            case 'phone':     return 'tel:' . preg_replace('/[^\d+]/', '', $value);
            case 'sms':       return 'sms:' . preg_replace('/[^\d+]/', '', $value);
            case 'website':
            case 'custom':    return preg_match('#^https?://#i', $value) ? $value : 'https://' . $value;
        }
        return $value;
    }

    $channels = [];
    if (!empty($settings['channels']) && is_array($settings['channels'])) {
        foreach ($settings['channels'] as $row) {
            if (!is_array($row)) continue;
            $platform = $row['platform'] ?? 'custom';
            if (!isset($brands[$platform])) $platform = 'custom';
            $value = $row['value'] ?? '';
            if ($value === '') continue;
            $channels[] = [
                'platform' => $platform,
                'value'    => $value,
                'label'    => $row['label'] ?: ($brands[$platform]['label'] ?? 'Link'),
                'icon'     => $row['icon'] ?? '',
                'color'    => $row['color'] ?: ($brands[$platform]['color'] ?? $accent),
                'url'      => rj_mc_build_url($platform, $value),
                'svg'      => $icons[$platform] ?? $icons['custom'],
            ];
        }
    }

    $posStyle = [
        'bottom-right' => 'bottom: 24px; right: 24px;',
        'bottom-left'  => 'bottom: 24px; left: 24px;',
        'top-right'    => 'top: 24px; right: 24px;',
        'top-left'     => 'top: 24px; left: 24px;',
    ];
    $posCss = $posStyle[$position] ?? $posStyle['bottom-right'];
    $isLeft = str_contains($position, 'left');
    $isTop  = str_contains($position, 'top');
@endphp

<style>
    #{{ $uid }} {
        --mc-size: {{ $sizePx }}px;
        --mc-accent: {{ $accent }};
        position: fixed;
        {!! $posCss !!}
        z-index: 9990;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    #{{ $uid }} .rj-mc-main {
        position: relative;
        width: var(--mc-size);
        height: var(--mc-size);
        border-radius: 50%;
        border: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(135deg, var(--mc-accent), {{ $accent }});
        box-shadow: 0 12px 28px -8px rgba(0,0,0,.35), 0 0 0 0 rgba(0,0,0,.1);
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .3s ease;
    }
    #{{ $uid }} .rj-mc-main:hover {
        transform: scale(1.08);
        box-shadow: 0 16px 36px -8px rgba(0,0,0,.4);
    }
    #{{ $uid }} .rj-mc-main:active { transform: scale(.96); }
    #{{ $uid }} .rj-mc-main svg {
        width: 55%;
        height: 55%;
        transition: transform .4s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }}.is-open .rj-mc-main svg {
        transform: rotate(135deg);
    }

    @if($pulse)
    #{{ $uid }} .rj-mc-main::before,
    #{{ $uid }} .rj-mc-main::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: var(--mc-accent);
        opacity: .5;
        z-index: -1;
        animation: rjMcPing 2s cubic-bezier(0, 0, .2, 1) infinite;
    }
    #{{ $uid }} .rj-mc-main::after { animation-delay: 1s; }
    @endif
    @keyframes rjMcPing {
        0%   { transform: scale(1); opacity: .5; }
        80%, 100% { transform: scale(1.8); opacity: 0; }
    }

    #{{ $uid }} .rj-mc-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        border-radius: 10px;
        background: #ef4444;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,.25);
        animation: rjMcBounce 2s ease-in-out infinite;
    }
    @keyframes rjMcBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    #{{ $uid }} .rj-mc-greeting {
        position: absolute;
        {!! $isLeft ? 'left: calc(var(--mc-size) + 12px);' : 'right: calc(var(--mc-size) + 12px);' !!}
        bottom: 0;
        max-width: 240px;
        min-width: 180px;
        padding: 12px 14px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 12px 28px -8px rgba(15,23,42,.3);
        font-size: 12.5px;
        line-height: 1.5;
        color: #334155;
        opacity: 0;
        transform: translateY(10px) scale(.9);
        pointer-events: none;
        transition: opacity .35s ease, transform .4s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .rj-mc-greeting.is-visible {
        opacity: 1;
        transform: none;
        pointer-events: auto;
    }
    #{{ $uid }} .rj-mc-greeting::after {
        content: '';
        position: absolute;
        bottom: 16px;
        {!! $isLeft ? 'left: -6px; border-right: 8px solid #fff; border-top: 6px solid transparent; border-bottom: 6px solid transparent;' : 'right: -6px; border-left: 8px solid #fff; border-top: 6px solid transparent; border-bottom: 6px solid transparent;' !!}
    }
    #{{ $uid }} .rj-mc-greeting-close {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 18px;
        height: 18px;
        border: 0;
        background: #f1f5f9;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        padding: 0;
    }
    #{{ $uid }} .rj-mc-greeting-close:hover { background: #e2e8f0; color: #0f172a; }

    #{{ $uid }} .rj-mc-list {
        position: absolute;
        bottom: calc(var(--mc-size) + 10px);
        {!! $isLeft ? 'left: 0;' : 'right: 0;' !!}
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding-bottom: 4px;
        pointer-events: none;
    }
    #{{ $uid }}[data-pos-top] .rj-mc-list {
        bottom: auto;
        top: calc(var(--mc-size) + 10px);
        flex-direction: column-reverse;
    }

    #{{ $uid }} .rj-mc-item {
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transform: translateY(12px) scale(.9);
        transition: opacity .35s ease, transform .4s cubic-bezier(.34,1.56,.64,1);
        pointer-events: none;
        justify-content: {!! $isLeft ? 'flex-start' : 'flex-end' !!};
        flex-direction: {!! $isLeft ? 'row' : 'row-reverse' !!};
    }
    #{{ $uid }}.is-open .rj-mc-item {
        opacity: 1;
        transform: none;
        pointer-events: auto;
    }
    @for($i = 0; $i < 20; $i++)
    #{{ $uid }}.is-open .rj-mc-item:nth-child({{ $i + 1 }}) { transition-delay: {{ $i * 0.06 }}s; }
    @endfor

    #{{ $uid }} .rj-mc-btn {
        position: relative;
        width: calc(var(--mc-size) * .82);
        height: calc(var(--mc-size) * .82);
        border-radius: 50%;
        border: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: var(--mc-b, #666);
        text-decoration: none;
        box-shadow: 0 8px 20px -6px rgba(0,0,0,.3);
        transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-mc-btn:hover {
        transform: scale(1.12);
        box-shadow: 0 12px 24px -6px rgba(0,0,0,.4);
    }
    #{{ $uid }} .rj-mc-btn svg {
        width: 52%;
        height: 52%;
    }

    #{{ $uid }}[data-icon="mono"] .rj-mc-btn {
        background: #1e293b;
    }
    #{{ $uid }}[data-icon="custom"] .rj-mc-btn {
        background: var(--mc-accent);
    }

    #{{ $uid }} .rj-mc-label {
        padding: 6px 12px;
        background: #0f172a;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0,0,0,.2);
        position: relative;
    }
    #{{ $uid }} .rj-mc-label::after {
        content: '';
        position: absolute;
        top: 50%;
        {!! $isLeft ? 'left: -5px; border-right: 6px solid #0f172a; border-top: 5px solid transparent; border-bottom: 5px solid transparent; transform: translateY(-50%);' : 'right: -5px; border-left: 6px solid #0f172a; border-top: 5px solid transparent; border-bottom: 5px solid transparent; transform: translateY(-50%);' !!}
    }

    @media (max-width: 640px) {
        #{{ $uid }} {
            {!! $isTop ? 'top: 16px;' : 'bottom: 16px;' !!}
            {!! $isLeft ? 'left: 16px;' : 'right: 16px;' !!}
        }
        #{{ $uid }} .rj-mc-label { display: none; }
        #{{ $uid }} .rj-mc-greeting { max-width: 200px; min-width: 0; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $uid }}"
     data-pos="{{ $position }}"
     data-trigger="{{ $trigger }}"
     data-icon="{{ $iconStyle }}"
     {!! $isTop ? 'data-pos-top' : '' !!}>

    <button type="button" class="rj-mc-main" aria-label="{{ $mainLabel }}" aria-expanded="false">
        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
        @if($badge !== '')
            <span class="rj-mc-badge">{{ $badge }}</span>
        @endif
    </button>

    @if($greeting !== '')
        <div class="rj-mc-greeting" data-greeting>
            <button type="button" class="rj-mc-greeting-close" data-greeting-close aria-label="{{ __('Close') }}">
                <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            {{ $greeting }}
        </div>
    @endif

    @if(!empty($channels))
        <div class="rj-mc-list" role="menu">
            @foreach($channels as $ch)
                <div class="rj-mc-item">
                    @if($showLabels)
                        <span class="rj-mc-label">{{ $ch['label'] }}</span>
                    @endif
                    <a href="{{ $ch['url'] }}"
                       class="rj-mc-btn"
                       style="--mc-b: {{ $ch['color'] }};"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="{{ $ch['label'] }}"
                       role="menuitem">
                        {!! $ch['svg'] !!}
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var mainBtn  = root.querySelector('.rj-mc-main');
    var trigger  = root.getAttribute('data-trigger') || 'click';
    var greeting = root.querySelector('[data-greeting]');
    var gClose   = root.querySelector('[data-greeting-close]');
    var delay    = {{ $greetingDelay }};

    function open() {
        root.classList.add('is-open');
        mainBtn.setAttribute('aria-expanded', 'true');
        if (greeting) greeting.classList.remove('is-visible');
    }
    function close() {
        root.classList.remove('is-open');
        mainBtn.setAttribute('aria-expanded', 'false');
    }
    function toggle() {
        if (root.classList.contains('is-open')) close(); else open();
    }

    if (trigger === 'hover') {
        root.addEventListener('mouseenter', open);
        root.addEventListener('mouseleave', close);
    } else {
        mainBtn.addEventListener('click', toggle);
    }

    document.addEventListener('click', function (e) {
        if (trigger !== 'click') return;
        if (!root.contains(e.target)) close();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && root.classList.contains('is-open')) close();
    });

    if (greeting && delay >= 0) {
        setTimeout(function () {
            if (!root.classList.contains('is-open')) {
                greeting.classList.add('is-visible');
            }
        }, delay * 1000);
    }
    if (gClose && greeting) {
        gClose.addEventListener('click', function () {
            greeting.classList.remove('is-visible');
        });
    }
})();
</script>
