<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $fillable = ['user_id', 'reward_id', 'status'];

    public function reward()
    {
        return $this->belongsTo(Reward::class)->withTrashed(); // للسماح بالوصول إلى الجوائز المحذوفة
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
