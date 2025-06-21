<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'path',
        'type',
        'disk',
        'mime_type',
        'size',
        'mediable_id',
        'mediable_type',
    ];

    /**
     * Get the owning model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the full URL of the media.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        if ($this->disk === 'public') {
            return asset('/storage/' . ltrim($this->path, '/'));
        }

        return asset(Storage::disk($this->disk)->url($this->path));
    }
}