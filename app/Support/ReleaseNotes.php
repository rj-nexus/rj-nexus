<?php

namespace App\Support;

class ReleaseNotes
{
    /** Yalnız bu sözlərlə BAŞLAYAN başlıqlar atlanır (mötərizədə "Removed Downloads" kimi başlıqlar qorunur). */
    private const SKIP = '/^(overview|summary|install|upgrad|resources|links|download|documentation)/i';

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

            if (str_starts_with($trim, '```') || str_starts_with($trim, '~~~')) {
                $inCode = !$inCode;
                continue;
            }
            if ($inCode) {
                continue;
            }

            if (preg_match('/^#{1,2}\s+(.+)$/u', $trim, $m)) {
                $title   = self::headingText($m[1]);
                $skip    = $title === '' || (bool) preg_match(self::SKIP, $title);
                $current = $title;
                $inTable = false;
                continue;
            }

            if (preg_match('/^#{3,6}\s+/', $trim)) {
                $inTable = false;
                continue;
            }

            if ($skip) {
                continue;
            }

            if (str_starts_with($trim, '|')) {
                if (preg_match('/^\|[\s:|-]+\|?$/', $trim) && str_contains($trim, '--')) {
                    $inTable = true;
                    continue;
                }
                if (!$inTable) {
                    $inTable = true;
                    continue;
                }

                $row = str_replace('\\|', "\x00PIPE\x00", $trim);
                $cells = array_map('trim', explode('|', trim($row, '|')));
                $cells = array_map(fn($c) => str_replace("\x00PIPE\x00", '|', $c), $cells);

                self::push($groups, $current, $cells[0] ?? '', $cells[1] ?? '');
                continue;
            }
            $inTable = false;

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

    private static function clean(string $s): string
    {
        $s = preg_replace('/!\[[^\]]*\]\([^)]*\)/', '', $s);
        $s = preg_replace('/\[([^\]]*)\]\([^)]*\)/', '$1', $s);
        $s = preg_replace('/<[^>]+>/', '', $s);
        $s = preg_replace('#https?://\S+#i', '', $s);

        return trim(preg_replace('/\s{2,}/', ' ', $s));
    }

    private static function format(string $s): string
    {
        if ($s === '') {
            return '';
        }

        $s = e($s);

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