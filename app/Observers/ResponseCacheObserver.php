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
        if (!class_exists(ResponseCache::class)) {
            return;
        }

        if (!config('responsecache.enabled', false)) {
            return;
        }

        try {
            ResponseCache::clear();
        } catch (\Throwable $e) {
            Log::warning('Response cache clear failed (' . get_class($model) . '::' . $event . '): ' . $e->getMessage());
        }
    }
}