<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PdfReaderWidget extends BaseWidget
{
    public function id(): string
    {
        return 'pdf-reader';
    }

    public function name(): string
    {
        return __('PDF Reader');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Embed a PDF with pagination, zoom, fullscreen and download.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'pdf_file',
                'type' => 'media',
                'label' => __('Upload PDF'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Choose a PDF from the media library. If set, it is used instead of the URL below.'),
            ],
            [
                'name' => 'pdf_url',
                'type' => 'text',
                'label' => __('PDF URL'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => 'https://example.com/document.pdf',
                'help' => __('Direct URL to a PDF file (http or https).'),
            ],
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => '', 'tab' => 'content', 'placeholder' => __('Optional title above the PDF')],
            ['name' => 'download_name', 'type' => 'text', 'label' => __('Download Filename'), 'default' => '', 'tab' => 'content', 'placeholder' => __('e.g. api-docs.pdf'), 'help' => __('Leave empty to keep the original name.')],
            ['name' => 'start_page', 'type' => 'text', 'label' => __('Start Page'), 'default' => '1', 'tab' => 'content'],

            ['name' => 'show_download', 'type' => 'toggle', 'label' => __('Show Download Button'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_controls', 'type' => 'toggle', 'label' => __('Show Navigation Toolbar'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_open_new', 'type' => 'toggle', 'label' => __('Show "Open in New Tab" Link'), 'default' => true, 'tab' => 'content'],

            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Viewer Height'),
                'default' => '700',
                'tab' => 'style',
                'options' => [
                    '500' => __('Compact (500px)'),
                    '700' => __('Standard (700px)'),
                    '900' => __('Tall (900px)'),
                    'full' => __('Full Viewport (80vh)'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'clean',
                'tab' => 'style',
                'options' => [
                    'clean' => __('Clean (Card)'),
                    'dark' => __('Dark Theme'),
                    'minimal' => __('Minimal (No Card)'),
                ],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#6366f1', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        // Media kitabxanasından seçilmiş fayl URL-dən üstündür
        $file = $this->fileUrl($settings['pdf_file'] ?? '');
        $url = $file !== '' ? $file : trim((string) ($settings['pdf_url'] ?? ''));

        if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        if (!in_array($scheme, ['http', 'https'], true)) {
            return '';
        }

        $opts = [
            'title' => trim((string) ($settings['title'] ?? '')),
            'download_name' => trim((string) ($settings['download_name'] ?? '')),
            'start_page' => max(1, (int) ($settings['start_page'] ?? 1)),
            'show_download' => $this->toBool($settings['show_download'] ?? null, true),
            'show_controls' => $this->toBool($settings['show_controls'] ?? null, true),
            'show_open_new' => $this->toBool($settings['show_open_new'] ?? null, true),
            'height' => in_array($settings['height'] ?? '700', ['500', '700', '900', 'full'], true)
                ? $settings['height'] : '700',
            'style' => in_array($settings['style'] ?? 'clean', ['clean', 'dark', 'minimal'], true)
                ? $settings['style'] : 'clean',
            'accent' => $this->hex($settings['accent_color'] ?? null, '#6366f1'),
        ];

        $uid = 'pdf_' . substr(md5(uniqid('', true)), 0, 8);
        $src = $this->resolveSource($url);

        return view('rjbuilder.widgets.builtin.pdf-reader', compact('url', 'src', 'opts', 'uid'))->render();
    }

    /**
     * Media idarəedicisindən gələn dəyəri (string və ya massiv) tam URL-ə çevirir.
     */
    private function fileUrl(mixed $value): string
    {
        if (is_object($value)) { $value = (array) $value; }

        if (is_array($value)) {
            $found = '';
            foreach (['url', 'src', 'path', 'file', 'original', 'full'] as $key) {
                if (!empty($value[$key]) && is_string($value[$key])) { $found = $value[$key]; break; }
            }
            $value = $found;
        }

        if (!is_string($value)) { return ''; }
        $value = trim($value);
        if ($value === '') { return ''; }

        if (str_starts_with($value, '//')) { $value = request()->getScheme() . ':' . $value; }

        $origin = rtrim(request()->getSchemeAndHttpHost(), '/');

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $value)) {
            if (!preg_match('/^https?:/i', $value)) { return ''; }

            $parts = parse_url($value);
            $host = strtolower((string) ($parts['host'] ?? ''));
            $reqHost = strtolower(request()->getHost());
            $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));
            $local = in_array($host, ['localhost', '127.0.0.1', '::1', '[::1]'], true)
                || ($appHost !== '' && $host === $appHost);

            // APP_URL / localhost ilə saxlanmış linkləri cari domenə çevir
            if ($host !== '' && $host !== $reqHost && $local) {
                return $origin . ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');
            }

            return $value;
        }

        if (str_starts_with($value, '/')) { return $origin . $value; }

        return $origin . '/' . ltrim($value, '/');
    }

    /**
     * Xarici PDF-i serverə keşləyir ki, brauzer same-origin oxusun (CORS problemi olmasın).
     * Alınmasa, orijinal URL qaytarılır.
     */
    private function resolveSource(string $url): string
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        // Eyni saytın PDF-i (media kitabxanası daxil): keşləməyə ehtiyac yoxdur
        if ($host === strtolower(request()->getHost())) {
            return $url;
        }

        $path = 'rjpdf/' . md5($url) . '.pdf';
        $disk = Storage::disk('public');

        // 7 gündən təzədirsə, keşdən istifadə et
        if ($disk->exists($path) && $disk->lastModified($path) > now()->subDays(7)->timestamp) {
            return asset('storage/' . $path);
        }

        try {
            // SSRF qoruması: daxili/private IP-lər olmaz
            $ip = gethostbyname($host);
            if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $url;
            }

            $res = Http::timeout(25)
                ->withOptions(['allow_redirects' => ['max' => 3, 'protocols' => ['http', 'https']]])
                ->withHeaders(['Accept' => 'application/pdf', 'User-Agent' => 'Mozilla/5.0'])
                ->get($url);

            $body = $res->body();

            if (!$res->ok() || strlen($body) > 30 * 1024 * 1024 || !str_starts_with($body, '%PDF')) {
                return $url;
            }

            $disk->put($path, $body);

            return asset('storage/' . $path);
        } catch (\Throwable $e) {
            report($e);

            return $url;
        }
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