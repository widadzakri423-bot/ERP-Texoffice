<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', 'Création');
        });

        static::updated(function ($model) {
            $model->logActivity('updated', 'Modification');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', 'Suppression');
        });
    }

    public function logActivity(string $action, string $description)
    {
        if (auth()->check()) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'model_type' => class_basename($this),
                'model_id' => $this->id,
                'description' => $description . ' : ' . class_basename($this) . ' #' . $this->id,
            ]);
        }
    }
}