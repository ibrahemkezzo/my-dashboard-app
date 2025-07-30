<?php

namespace App\Models;

use App\Traits\HasDynamicMediaUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasDynamicMediaUrl;
    
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
     * Define how to retrieve media data for the Media model.
     *
     * @return array|null
     */
    protected function getMediaData()
    {
        if ($this->path && $this->disk) {
            return [
                'path' => $this->path,
                'disk' => $this->disk,
            ];
        }

        return null;
    }
}