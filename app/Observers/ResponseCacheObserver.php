<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\ResponseCache\Facades\ResponseCache;

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

    public function restored(Model $model): void
    {
        $this->clear($model, 'restored');
    }

    protected function clear(Model $model, string $event): void
    {
        // Əgər Spatie paketi quraşdırılmayıbsa, heç nə etmə
        if (!class_exists(ResponseCache::class)) {
            return;
        }

        // DÜZƏLİŞ: Config yerinə Admin Paneldəki ayarı yoxlayırıq
        if (function_exists('rj_get_option') && rj_get_option('response_cache_enabled', '0') !== '1') {
            return;
        }

        try {
            ResponseCache::clear();
        } catch (\Throwable $e) {
            Log::warning('Response cache clear failed (' . get_class($model) . '::' . $event . '): ' . $e->getMessage());
        }
    }
}