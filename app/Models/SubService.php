<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    protected $fillable = [
        'service_id', 'name', 'description', 'order', 'status', 'icon_or_image', 'seo_meta',
    ];

    protected $casts = [
        'seo_meta' => 'array',
        'status' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Future: salons many-to-many
    // public function salons()
    // {
    //     return $this->belongsToMany(Salon::class)->withPivot('details', 'requirements');
    // }
}
