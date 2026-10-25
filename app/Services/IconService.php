<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class IconService
{
    protected string $apiUrl = 'https://api.iconify.design';

    public function get(string $name, string $class = '', string $size = '24'): string
    {
        $name = str_replace(':', '/', $name);

        $cacheKey = 'rj_icon_' . md5($name);

        $svg = Cache::rememberForever($cacheKey, function () use ($name) {
            $localPath = storage_path('app/icons/' . str_replace('/', '_', $name) . '.svg');

            if (File::exists($localPath)) {
                return File::get($localPath);
            }

            try {
                $response = Http::timeout(5)->get("{$this->apiUrl}/{$name}.svg");

                if ($response->successful()) {
                    $content = $response->body();

                    if (!File::isDirectory(storage_path('app/icons'))) {
                        File::makeDirectory(storage_path('app/icons'), 0755, true);
                    }
                    File::put($localPath, $content);

                    return $content;
                }
            } catch (\Throwable $e) {
                return '';
            }

            return '';
        });

        if (empty($svg)) {
            return '';
        }

        $svg = preg_replace('/<svg([^>]*)>/', '<svg $1 class="' . $class . '" width="' . $size . '" height="' . $size . '">', $svg, 1);

        return $svg;
    }
}
