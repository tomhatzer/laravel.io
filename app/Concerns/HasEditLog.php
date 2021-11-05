<?php

namespace App\Concerns;

use App\Models\Edit;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait HasEditLog
{
    public static function bootHasEditLog()
    {
        static::updated(function ($model) {
            Edit::create([
                'author_id' => $model->author_id,
                'editable_id' => $model->id,
                'editable_type' => constant($model::class.'::TABLE') ?? $model::class,
                'edited_at' => now(),
            ]);

            $cacheKey = sprintf('%s-%s', Str::slug($model::class), $model->id);
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        });
    }

    public function edits(): MorphMany
    {
        return $this->morphMany(Edit::class, 'editable');
    }

    public function getLatestEditAttribute(): ?Edit
    {
        $cacheKey = sprintf('%s-%s', Str::slug($this::class), $this->id);

        return Cache::rememberForever($cacheKey, function () {
            return $this->edits()->latest('edited_at')->first();
        });
    }
}