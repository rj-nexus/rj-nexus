<?php

use App\Services\IconService;

if (!function_exists('rj_icon')) {
    function rj_icon(string $name, string $class = '', string $size = '24'): string
    {
        return app(IconService::class)->get($name, $class, $size);
    }
}
