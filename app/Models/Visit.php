<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

/**
 * Model representing a website visit.
 */
class Visit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id',
        'page_url',
        'time_spent',
        'visited_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'visited_at' => 'datetime',
        'time_spent' => 'integer',
    ];

    /**
     * Get the session that owns the visit.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'session_id', 'session_id');
    }

    /**
     * Get the user associated with the visit via the session.
     */
    public function user()
    {
        return $this->session ? $this->session->user() : null;
    }

    /**
     * Get the user name or a placeholder if not available.
     */
    public function getUserNameAttribute()
    {
        return $this->session && $this->session->user ? $this->session->user->name : 'Guest';
    }
}
