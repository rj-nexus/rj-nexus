<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SocialFeedWidget extends BaseWidget
{
    protected const PLATFORMS = ['twitter', 'instagram', 'piokio', 'dehliz', 'reax', 'web'];

    protected const LINK_KEYS    = ['url', 'link', 'permalink', 'external_url', 'post_url', 'href'];
    protected const TEXT_KEYS    = ['content_html', 'content_text', 'content', 'description', 'summary', 'caption', 'text', 'body', 'message'];
    protected const TITLE_KEYS   = ['title', 'name'];
    protected const IMAGE_KEYS   = ['image', 'image_url', 'imageurl', 'thumbnail', 'thumbnail_url', 'media', 'media_url', 'picture', 'photo', 'banner_image', 'cover', 'enclosure', 'attachments'];
    protected const DATE_KEYS    = ['date_published', 'date_modified', 'pubdate', 'published', 'date', 'created_at', 'updated', 'timestamp'];
    protected const LIST_KEYS    = ['items', 'data', 'posts', 'entries', 'results'];

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
        return __('A social feed grid with RSS/JSON/CSV auto-feed and manual posts.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Section Title'), 'default' => __('Follow us'), 'tab' => 'content'],
            ['name' => 'subtitle', 'type' => 'text', 'label' => __('Section Subtitle'), 'default' => __('Latest from our social channels'), 'tab' => 'content'],
            [
                'name'           => 'enable_rss',
                'type'           => 'toggle',
                'label'          => __('Enable Auto-Feed'),
                'default'        => false,
                'tab'            => 'content',
                'help'           => __('Posts are fetched on the server and cached. Supports RSS, Atom, JSON Feed and CSV.'),
                'help_link'      => 'https://rss.app/pricing',
                'help_link_text' => __('View pricing →'),
            ],
            [
                'name'           => 'rss_url',
                'type'           => 'text',
                'label'          => __('Feed URL'),
                'default'        => '',
                'tab'            => 'content',
                'help'           => __('Any XML, JSON or CSV feed address, for example https://rss.app/feeds/xxxx.xml'),
                'help_link'      => 'https://rss.app',
                'help_link_text' => __('Open rss.app →'),
            ],
            ['name' => 'rss_limit', 'type' => 'number', 'label' => __('Post Limit'), 'default' => 9, 'min' => 1, 'max' => 30, 'step' => 1, 'tab' => 'content'],
            ['name' => 'rss_cache', 'type' => 'number', 'label' => __('Cache (minutes)'), 'default' => 15, 'min' => 1, 'max' => 1440, 'step' => 1, 'tab' => 'content'],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'grid',
                'tab'     => 'style',
                'options' => ['grid' => __('Grid'), 'masonry' => __('Masonry'), 'carousel' => __('Carousel')],
            ],
            [
                'name'    => 'columns',
                'type'    => 'select',
                'label'   => __('Columns'),
                'default' => '3',
                'tab'     => 'style',
                'options' => ['2' => __('2 Columns'), '3' => __('3 Columns'), '4' => __('4 Columns')],
            ],
            [
                'name'    => 'gap',
                'type'    => 'select',
                'label'   => __('Gap'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => ['sm' => __('Small'), 'md' => __('Medium'), 'lg' => __('Large')],
            ],
            [
                'name'    => 'aspect',
                'type'    => 'select',
                'label'   => __('Card Ratio'),
                'default' => '1/1',
                'tab'     => 'style',
                'options' => ['1/1' => __('Square'), '4/3' => __('Landscape'), '3/4' => __('Portrait'), '16/9' => __('Wide')],
            ],
            ['name' => 'show_platform', 'type' => 'toggle', 'label' => __('Show Platform Icon'), 'default' => true, 'tab' => 'style'],
            ['name' => 'show_caption', 'type' => 'toggle', 'label' => __('Show Caption'), 'default' => true, 'tab' => 'style'],
            ['name' => 'show_date', 'type' => 'toggle', 'label' => __('Show Date'), 'default' => true, 'tab' => 'style'],
            ['name' => 'accent', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => ['none' => __('None'), 'md' => __('Medium'), 'lg' => __('Large'), 'xl' => __('Extra Large')],
            ],
            ['name' => 'padding_y', 'type' => 'range', 'label' => __('Vertical Padding'), 'default' => 60, 'min' => 0, 'max' => 160, 'step' => 4, 'tab' => 'style'],
            ['name' => 'show_tabs', 'type' => 'toggle', 'label' => __('Show Platform Filter Tabs'), 'default' => true, 'tab' => 'content'],
            [
                'name'   => 'items',
                'type'   => 'repeater',
                'label'  => __('Manual Posts (fallback)'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'platform', 'type' => 'select', 'label' => __('Platform'), 'options' => [
                        'twitter'   => 'Twitter / X',
                        'instagram' => 'Instagram',
                        'piokio'    => 'Piokio',
                        'dehliz'    => 'Dehliz',
                        'reax'      => 'Reax',
                        'web'       => 'Web',
                    ]],
                    ['name' => 'image', 'type' => 'media', 'label' => __('Image')],
                    ['name' => 'caption', 'type' => 'textarea', 'label' => __('Caption')],
                    ['name' => 'url', 'type' => 'text', 'label' => __('Post URL')],
                    ['name' => 'date', 'type' => 'text', 'label' => __('Date (e.g. 2026-10-27)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid      = 'sf_' . substr(md5(uniqid('', true)), 0, 8);
        $items    = [];
        $rssError = '';
        $rssUrl   = trim((string) ($settings['rss_url'] ?? ''));

        if (filter_var($settings['enable_rss'] ?? false, FILTER_VALIDATE_BOOLEAN) && $rssUrl !== '') {
            $limit    = max(1, min(30, (int) ($settings['rss_limit'] ?? 9)));
            $minutes  = max(1, min(1440, (int) ($settings['rss_cache'] ?? 15)));
            $result   = $this->fetchRss($rssUrl, $limit, $minutes);
            $items    = $result['items'];
            $rssError = $result['error'];
        }

        if (!$items) {
            $items = $this->manualItems($settings['items'] ?? []);
        }

        return view('rjbuilder.widgets.builtin.social-feed', compact('settings', 'uid', 'items', 'rssError'))->render();
    }

    protected function manualItems($rows): array
    {
        $items = [];
        foreach ((array) $rows as $row) {
            if (!is_array($row)) continue;
            $image   = $this->safeImage((string) ($row['image'] ?? ''));
            $caption = trim((string) ($row['caption'] ?? ''));
            if ($image === '' && $caption === '') continue;
            $platform = (string) ($row['platform'] ?? 'twitter');
            $items[] = [
                'platform' => in_array($platform, self::PLATFORMS, true) ? $platform : 'web',
                'image'    => $image,
                'caption'  => $caption,
                'url'      => $this->safeUrl((string) ($row['url'] ?? '')),
                'date'     => trim((string) ($row['date'] ?? '')),
            ];
        }
        return $items;
    }

    protected function fetchRss(string $url, int $limit, int $minutes): array
    {
        $host = (string) parse_url($url, PHP_URL_HOST);
        if (!preg_match('#^https?://#i', $url) || $host === '') {
            return ['items' => [], 'error' => 'Invalid feed URL'];
        }

        $key = 'rj_sf_feed_' . md5($url . '|' . $limit);
        $hit = Cache::get($key);
        if (is_array($hit) && $hit) {
            return ['items' => $hit, 'error' => ''];
        }

        $ip = gethostbyname($host);
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return ['items' => [], 'error' => 'Feed host could not be resolved or is not public'];
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; RJ-CMS FeedReader)',
                    'Accept'     => 'application/rss+xml, application/atom+xml, application/feed+json, application/json, application/xml, text/xml, text/csv, */*',
                ])
                ->get($url);

            if (!$response->successful()) {
                throw new \RuntimeException('HTTP ' . $response->status());
            }

            $items = $this->parseFeed($response->body(), $limit);
            if (!$items) {
                throw new \RuntimeException('Feed has no readable posts');
            }

            Cache::put($key, $items, now()->addMinutes($minutes));
            Cache::put($key . '_last', $items, now()->addDays(7));

            return ['items' => $items, 'error' => ''];
        } catch (\Throwable $e) {
            Log::warning('SocialFeed failed: ' . $e->getMessage(), ['url' => $url]);
            $last = Cache::get($key . '_last');

            return ['items' => is_array($last) ? $last : [], 'error' => $e->getMessage()];
        }
    }

    protected function parseFeed(string $body, int $limit): array
    {
        $body  = ltrim($body, "\xEF\xBB\xBF \t\n\r");
        $first = $body[0] ?? '';

        if ($first === '<') return $this->parseXml($body, $limit);
        if ($first === '{' || $first === '[') return $this->parseJson($body, $limit);

        return $this->parseCsv($body, $limit);
    }

    protected function parseJson(string $body, int $limit): array
    {
        $data = json_decode($body, true);
        if (!is_array($data)) return [];

        $rows = $data;
        if (!array_is_list($data)) {
            $rows = [];
            foreach (self::LIST_KEYS as $k) {
                if (isset($data[$k]) && is_array($data[$k])) { $rows = $data[$k]; break; }
            }
        }

        $feedPlatform = $this->platformFromUrl((string) ($data['home_page_url'] ?? $data['link'] ?? ''));

        return $this->buildItems($rows, $feedPlatform, $limit);
    }

    protected function parseCsv(string $body, int $limit): array
    {
        $firstLine = strtok($body, "\n") ?: '';
        $delims    = [',' => substr_count($firstLine, ','), ';' => substr_count($firstLine, ';'), "\t" => substr_count($firstLine, "\t")];
        arsort($delims);
        $delim = (string) array_key_first($delims);

        $h = fopen('php://temp', 'r+');
        fwrite($h, $body);
        rewind($h);

        $head = fgetcsv($h, 0, $delim, '"', '');
        if (!$head) { fclose($h); return []; }
        $head = array_map(fn ($v) => strtolower(trim((string) $v)), $head);

        $rows = [];
        while (($line = fgetcsv($h, 0, $delim, '"', '')) !== false) {
            if ($line === [null]) continue;
            $rows[] = array_combine($head, array_slice(array_pad($line, count($head), ''), 0, count($head)));
        }
        fclose($h);

        return $this->buildItems($rows, 'web', $limit);
    }

    protected function parseXml(string $body, int $limit): array
    {
        $previous = libxml_use_internal_errors(true);
        $xml = simplexml_load_string($body, \SimpleXMLElement::class, LIBXML_NOCDATA | LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (!$xml) return [];

        $nodes = isset($xml->channel->item) ? $xml->channel->item : (isset($xml->entry) ? $xml->entry : (isset($xml->item) ? $xml->item : []));
        $feedPlatform = $this->platformFromUrl((string) ($xml->channel->link ?? ''));
        $items = [];

        foreach ($nodes as $n) {
            if (count($items) >= $limit) break;

            $link = trim((string) $n->link);
            if ($link === '') {
                foreach ($n->link as $l) {
                    if ((string) ($l['href'] ?? '') !== '') { $link = (string) $l['href']; break; }
                }
            }

            $html = (string) $n->children('http://purl.org/rss/1.0/modules/content/')->encoded;
            foreach (['description', 'content', 'summary'] as $f) {
                if ($html === '') $html = (string) $n->$f;
            }

            $caption = $this->cleanText($html) ?: $this->cleanText((string) $n->title);
            $image   = $this->findImage($n, $html);
            if ($image === '' && $caption === '') continue;

            $raw = (string) $n->pubDate ?: (string) $n->published ?: (string) $n->updated ?: (string) $n->children('http://purl.org/dc/elements/1.1/')->date;

            $platform = $this->platformFromUrl($link);
            if ($platform === 'web') $platform = $feedPlatform;

            $items[] = [
                'platform' => $platform,
                'image'    => $image,
                'caption'  => Str::limit($caption, 320),
                'url'      => $this->safeUrl($link),
                'date'     => $this->formatDate($raw),
            ];
        }

        return $items;
    }

    protected function buildItems(array $rows, string $feedPlatform, int $limit): array
    {
        $items = [];
        foreach ($rows as $row) {
            if (count($items) >= $limit) break;
            if (!is_array($row)) continue;

            $item = $this->rowToItem($row, $feedPlatform);
            if ($item) $items[] = $item;
        }

        return $items;
    }

    protected function rowToItem(array $row, string $feedPlatform): ?array
    {
        $row     = array_change_key_case($row, CASE_LOWER);
        $link    = $this->pick($row, self::LINK_KEYS);
        $html    = $this->pick($row, self::TEXT_KEYS);
        $caption = $this->cleanText($html) ?: $this->cleanText($this->pick($row, self::TITLE_KEYS));
        $image   = $this->safeImage($this->pick($row, self::IMAGE_KEYS));

        if ($image === '' && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
            $image = $this->safeImage($m[1]);
        }
        if ($image === '' && $caption === '') return null;

        $platform = $this->platformFromUrl($link);
        if ($platform === 'web') $platform = $feedPlatform;

        return [
            'platform' => $platform,
            'image'    => $image,
            'caption'  => Str::limit($caption, 320),
            'url'      => $this->safeUrl($link),
            'date'     => $this->formatDate($this->pick($row, self::DATE_KEYS)),
        ];
    }

    protected function pick(array $row, array $keys): string
    {
        foreach ($keys as $k) {
            $v = $row[$k] ?? null;
            if (is_array($v)) {
                $v = $v['url'] ?? ($v[0]['url'] ?? ($v[0] ?? null));
            }
            if (is_scalar($v) && trim((string) $v) !== '') return trim((string) $v);
        }

        return '';
    }

    protected function formatDate(string $raw): string
    {
        if ($raw === '') return '';

        $ts = is_numeric($raw) ? (int) $raw : strtotime($raw);
        if ($ts && $ts > 100000000000) $ts = intdiv($ts, 1000);

        return $ts ? date('M j, Y', $ts) : '';
    }

    protected function findImage(\SimpleXMLElement $n, string $html): string
    {
        $media = $n->children('http://search.yahoo.com/mrss/');
        $pool  = [];
        foreach ($media->content as $c) $pool[] = $c;
        foreach ($media->thumbnail as $c) $pool[] = $c;
        if (isset($media->group)) {
            foreach ($media->group->content as $c) $pool[] = $c;
        }

        foreach ($pool as $c) {
            $u      = (string) ($c['url'] ?? '');
            $type   = (string) ($c['type'] ?? '');
            $medium = (string) ($c['medium'] ?? '');
            if ($u === '') continue;
            if ($type !== '' && stripos($type, 'image') !== 0) continue;
            if ($medium !== '' && $medium !== 'image') continue;
            $safe = $this->safeImage($u);
            if ($safe !== '') return $safe;
        }

        foreach ($n->enclosure as $e) {
            $u = (string) ($e['url'] ?? '');
            $t = (string) ($e['type'] ?? '');
            if ($u !== '' && ($t === '' || stripos($t, 'image') === 0)) {
                $safe = $this->safeImage($u);
                if ($safe !== '') return $safe;
            }
        }

        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
            return $this->safeImage($m[1]);
        }

        return '';
    }

    protected function cleanText(string $html): string
    {
        $html = preg_replace('/<\s*(br|\/p|\/div|\/li)[^>]*>/i', "\n", $html);
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[ \t\x{00A0}]+/u', ' ', $text);
        $text = preg_replace('/ *\n */', "\n", $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }

    protected function platformFromUrl(string $url): string
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        if (str_contains($host, 'instagram.')) return 'instagram';
        if (str_contains($host, 'twitter.') || $host === 'x.com' || str_ends_with($host, '.x.com')) return 'twitter';

        return 'web';
    }

    protected function safeUrl(string $url): string
    {
        $url = trim(html_entity_decode($url));

        return preg_match('#^https?://#i', $url) ? $url : '';
    }

    protected function safeImage(string $url): string
    {
        $url = trim(html_entity_decode($url));
        if (str_starts_with($url, '//')) $url = 'https:' . $url;

        return preg_match('#^(https?://|/)#i', $url) ? $url : '';
    }
}
