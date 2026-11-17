<?php

namespace App\Support;

class ReleaseNotes
{
    /** Bu başlıqlar altındakı məzmun göstərilmir. */
    private const SKIP = '/(overview|summary|install|upgrad|resources|links|download|documentation)/i';

    /**
     * Markdown release body-ni qruplara ayırır.
     *
     * Qaytarır:
     * [ ['title' => 'Added', 'type' => 'added', 'items' => [['title' => '..', 'text' => '..'], ...]], ... ]
     */
    public static function parse(?string $body): array
    {
        if (!$body || trim($body) === '') {
            return [];
        }

        $groups  = [];
        $current = 'Changes';
        $skip    = false;
        $inCode  = false;
        $inTable = false;

        foreach (preg_split('/\R/', $body) as $line) {
            $trim = trim($line);

            // Kod bloklarını keç
            if (str_starts_with($trim, '```') || str_starts_with($trim, '~~~')) {
                $inCode = !$inCode;
                continue;
            }
            if ($inCode) {
                continue;
            }

            // H1 / H2 başlıq: yeni qrup və ya keçid
            if (preg_match('/^#{1,2}\s+(.+)$/u', $trim, $m)) {
                $title   = self::headingText($m[1]);
                $skip    = $title === '' || (bool) preg_match(self::SKIP, $title);
                $current = $title;
                $inTable = false;
                continue;
            }

            // H3+ alt başlıqlar: qrupu dəyişmir
            if (preg_match('/^#{3,6}\s+/', $trim)) {
                $inTable = false;
                continue;
            }

            if ($skip) {
                continue;
            }

            // Cədvəl sətirləri
            if (str_starts_with($trim, '|')) {
                // Separator sətri: |---|---|
                if (preg_match('/^\|[\s:|-]+\|?$/', $trim) && str_contains($trim, '--')) {
                    $inTable = true;
                    continue;
                }
                // Header sətri (separatordan əvvəl)
                if (!$inTable) {
                    $inTable = true;
                    continue;
                }
                $cells = array_map('trim', explode('|', trim($trim, '|')));
                self::push($groups, $current, $cells[0] ?? '', $cells[1] ?? '');
                continue;
            }
            $inTable = false;

            // Bullet maddələr
            if (preg_match('/^[-*+]\s+(.+)$/u', $trim, $m)) {
                $title = '';
                $text  = $m[1];

                if (preg_match('/^\*\*(.+?)\*\*\s*(?:[—–:-]\s*)?(.*)$/u', $text, $mm)) {
                    $title = $mm[1];
                    $text  = $mm[2];
                }
                self::push($groups, $current, $title, $text);
            }
        }

        return array_values($groups);
    }

    private static function push(array &$groups, string $group, string $title, string $text): void
    {
        $title = rtrim(self::clean(str_replace('**', '', $title)), ': ');
        $text  = self::clean($text);

        if ($title === '' && $text === '') {
            return;
        }
        if ($text === '') {
            $text  = $title;
            $title = '';
        }

        $key = mb_strtolower($group);
        $groups[$key] ??= ['title' => $group, 'type' => self::type($group), 'items' => []];
        $groups[$key]['items'][] = [
            'title' => self::format($title),
            'text'  => self::format($text),
        ];
    }

    /** Şəkil, link, HTML və çılpaq URL-ləri təmizləyir. */
    private static function clean(string $s): string
    {
        $s = preg_replace('/!\[[^\]]*\]\([^)]*\)/', '', $s);      // şəkillər / badge-lər
        $s = preg_replace('/\[([^\]]*)\]\([^)]*\)/', '$1', $s);   // [mətn](url) -> mətn
        $s = preg_replace('/<[^>]+>/', '', $s);                    // HTML teqləri
        $s = preg_replace('#https?://\S+#i', '', $s);              // çılpaq URL-lər

        return trim(preg_replace('/\s{2,}/', ' ', $s));
    }

    /** Təhlükəsiz HTML: əvvəl escape, sonra yalnız qalın / italik / kod. */
    private static function format(string $s): string
    {
        if ($s === '') {
            return '';
        }

        $s = e($s);

        // Qalın (kod daxilində də işləyir, backtick-lər toxunulmaz qalır)
        $s = preg_replace('/\*\*(.+?)\*\*/su', '<strong>$1</strong>', $s);

        $parts = preg_split('/(`[^`]*`)/u', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
        $out   = '';

        foreach ($parts as $part) {
            if (strlen($part) >= 2 && $part[0] === '`' && substr($part, -1) === '`') {
                $out .= '<code>' . substr($part, 1, -1) . '</code>';
                continue;
            }

            $out .= preg_replace('/(?<!\*)\*(?!\s)([^*]+?)\*(?!\*)/u', '<em>$1</em>', $part);
        }

        return $out;
    }

    /** Emoji və xüsusi simvolları başlıqdan təmizləyir. */
    private static function headingText(string $h): string
    {
        $h = preg_replace('/[^\p{L}\p{N}\s&\/\-]/u', '', $h);

        return trim(preg_replace('/\s{2,}/', ' ', $h));
    }

    private static function type(string $group): string
    {
        $g = mb_strtolower($group);

        return match (true) {
            str_contains($g, 'secur')                                   => 'security',
            str_contains($g, 'fix')                                     => 'fixed',
            str_contains($g, 'add') || str_contains($g, 'new')          => 'added',
            str_contains($g, 'chang') || str_contains($g, 'improv')
                || str_contains($g, 'updat')                            => 'changed',
            str_contains($g, 'remov') || str_contains($g, 'deprec')     => 'removed',
            default                                                     => 'other',
        };
    }
}