<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\ResponseCache\Facades\ResponseCache;
use Litespeed\LSCache\LSCache; // YENİ

class ResponseCacheObserver
{
    public function saved(Model $model): void
    {
        $this->clear($model, 'saved');
    }

    public function deleted(Model $model): void
    {
        $this->clear($model, 'deleted');
    }

    protected function clear(Model $model, string $event): void
    {
        // 1. Spatie Keşini Təmizlə
        if (class_exists(ResponseCache::class) && function_exists('rj_get_option') && rj_get_option('response_cache_enabled', '0') === '1') {
            try {
                ResponseCache::clear();
            } catch (\Throwable $e) {
                Log::warning('Spatie cache clear failed: ' . $e->getMessage());
            }
        }

        // 2. LiteSpeed Keşini Təmizlə (YENİ)
        if (class_exists(LSCache::class)) {
            try {
                LSCache::purgeAll();
            } catch (\Throwable $e) {
                Log::warning('LiteSpeed cache clear failed: ' . $e->getMessage());
            }
        }
    }
}