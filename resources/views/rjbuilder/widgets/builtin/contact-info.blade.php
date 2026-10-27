@php
    $subtitle   = $settings['subtitle'] ?? '';
    $title      = $settings['title'] ?? '';
    $desc       = $settings['desc'] ?? '';
    $layoutRaw  = $settings['layout'] ?? 'cards';
    $layout     = in_array($layoutRaw, ['cards', 'rows', 'icon-left'], true) ? $layoutRaw : 'cards';
    $columns    = (int) ($settings['columns'] ?? 3);
    $columns    = max(1, min(4, $columns));
    $align      = ($settings['align'] ?? 'center') === 'left' ? 'left' : 'center';
    $cardStyleR = $settings['card_style'] ?? 'card';
    $cardStyle  = in_array($cardStyleR, ['card', 'bordered', 'minimal', 'gradient', 'glass'], true) ? $cardStyleR : 'card';
    $iconStyleR = $settings['icon_style'] ?? 'rounded';
    $iconStyle  = in_array($iconStyleR, ['circle', 'rounded', 'square', 'soft'], true) ? $iconStyleR : 'rounded';
    $showFooter = !empty($settings['show_footer_cta']);
    $footerLabel = $settings['footer_label'] ?? __('Contact Us');
    $footerUrl  = trim((string) ($settings['footer_url'] ?? '/contact'));
    $paddingY   = max(0, min(200, (int) ($settings['padding_y'] ?? 60)));

    $norm = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $v)) {
            $v = $d;
        }
        $h = ltrim($v, '#');
        if (strlen($h) === 3) {
            $h = $h[0] . $h[0] . $h[1] . $h[1] . $h[2] . $h[2];
        } elseif (strlen($h) === 8) {
            $h = substr($h, 0, 6);
        }
        return '#' . strtolower($h);
    };
    $toRgb = function ($hex) {
        $h = ltrim($hex, '#');
        return hexdec(substr($h, 0, 2)) . ',' . hexdec(substr($h, 2, 2)) . ',' . hexdec(substr($h, 4, 2));
    };

    $accent  = $norm($settings['accent'] ?? '', '#8b5cf6');
    $accent2 = $norm($settings['accent2'] ?? '', '#ec4899');
    $textCol = $norm($settings['text_color'] ?? '', '#0f172a');
    $muteCol = $norm($settings['muted_color'] ?? '', '#64748b');
    $accentRgb = $toRgb($accent);

    $radiusMap = ['none' => '0px', 'md' => '12px', 'lg' => '22px', 'xl' => '32px'];
    $radiusCss = $radiusMap[$settings['radius'] ?? 'lg'] ?? '22px';
    $iconShape = ['circle' => '999px', 'rounded' => '38px', 'square' => '0px', 'soft' => '56px 22px 56px 22px'];
    $iconRadius = $iconShape[$iconStyle];

    $safeUrl = function ($u) {
        $u = trim((string) $u);
        if ($u !== '' && preg_match('/^\s*(javascript|data|vbscript):/i', $u)) {
            return '';
        }
        return $u;
    };
    $footerUrl = $safeUrl($footerUrl);

    $typeIcons = [
        'address'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>',
        'phone'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>',
        'email'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M3.5 7.5l8.5 6 8.5-6"/></svg>',
        'hours'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>',
        'whatsapp' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21l1.6-4.6A8.5 8.5 0 1 1 8 19.5L3 21z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1-1.3-2-1-.8.6a3.5 3.5 0 0 1-1.6-1.6l.6-.8-1-2z"/></svg>',
        'telegram' => '<svg viewBox="0 0 24 24"
