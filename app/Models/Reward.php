<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reward extends Model
{
        use SoftDeletes;

    protected $fillable = ['required_points', 'description', 'type'];

    // علاقة مع user_rewards
    public function userRewards()
    {
        return $this->hasMany(UserReward::class);
    }
}
