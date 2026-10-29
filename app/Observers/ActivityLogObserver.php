<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ActivityLogObserver
{
    public function created(Model $model): void
    {
        $this->log($model, 'created');
    }

    public function updated(Model $model): void
    {
        if ($model->wasChanged() && !$this->onlyTimestampsChanged($model)) {
            $this->log($model, 'updated', $model->getChanges());
        }
    }

    public function deleted(Model $model): void
    {
        $this->log($model, 'deleted');
    }

    protected function log(Model $model, string $event, array $changes = []): void
    {
        if ($model instanceof ActivityLog) {
            return;
        }

        $basename = class_basename($model);
        $logName = Str::plural(Str::lower($basename));

        $title = $model->name ?? $model->title ?? $model->slug ?? $model->id;

        $description = match ($event) {
            'created' => __('Created :type: :title', ['type' => $basename, 'title' => $title]),
            'updated' => __('Updated :type: :title', ['type' => $basename, 'title' => $title]),
            'deleted' => __('Deleted :type: :title', ['type' => $basename, 'title' => $title]),
            default => __(':event :type: :title', ['event' => ucfirst($event), 'type' => $basename, 'title' => $title]),
        };

        ActivityLog::record([
            'log_name' => $logName,
            'description' => $description,
            'subject_type' => get_class($model),
            'subject_id' => $model->getKey(),
            'event' => $event,
            'properties' => $changes ? ['changes' => $changes] : null,
        ]);
    }

    protected function onlyTimestampsChanged(Model $model): bool
    {
        $changes = array_keys($model->getChanges());
        return count(array_diff($changes, ['updated_at', 'created_at'])) === 0;
    }
}
