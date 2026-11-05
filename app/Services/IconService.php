<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IconService
{
    protected string $apiUrl = 'https://api.iconify.design';

    public function get(string $name, string $class = '', string $size = '24'): string
    {
        $name = trim($name);
        if ($name === '') {
            return '';
        }

        $name = str_replace(':', '/', $name);
        $cacheKey = 'rj_icon_' . md5($name);

        $svg = Cache::get($cacheKey);

        if (empty($svg)) {
            $svg = $this->load($name);

            // Yalnız uğurlu nəticəni cache-ə yaz
            if (!empty($svg)) {
                Cache::forever($cacheKey, $svg);
            }
        }

        if (empty($svg)) {
            return '';
        }

        return $this->applyAttributes($svg, $class, $size);
    }

    protected function load(string $name): string
    {
        $dir = storage_path('app/icons');
        $localPath = $dir . '/' . str_replace('/', '_', $name) . '.svg';

        if (File::exists($localPath)) {
            $content = File::get($localPath);
            if (!empty($content)) {
                return $content;
            }
        }

        try {
            $response = Http::timeout(5)->get("{$this->apiUrl}/{$name}.svg");

            if ($response->successful() && str_contains($response->body(), '<svg')) {
                $content = $response->body();

                if (!File::isDirectory($dir)) {
                    File::makeDirectory($dir, 0755, true);
                }
                File::put($localPath, $content);

                return $content;
            }

            Log::warning('IconService: icon not loaded', [
                'name'   => $name,
                'status' => $response->status(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('IconService: request failed', [
                'name'  => $name,
                'error' => $e->getMessage(),
            ]);
        }

        return '';
    }

    protected function applyAttributes(string $svg, string $class, string $size): string
    {
        // Mövcud width/height/class atributlarını təmizlə
        $svg = preg_replace_callback('/<svg\b([^>]*)>/i', function ($m) use ($class, $size) {
            $attrs = preg_replace('/\s(width|height|class)="[^"]*"/i', '', $m[1]);

            $extra = ' width="' . e($size) . '" height="' . e($size) . '"';
            if ($class !== '') {
                $extra .= ' class="' . e($class) . '"';
            }

            return '<svg' . $attrs . $extra . '>';
        }, $svg, 1);

        return $svg;
    }
}
