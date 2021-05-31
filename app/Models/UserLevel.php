<?php

namespace App\Models;

use App\Models\User;
use App\Traits\PagerTrait;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    use PagerTrait;
    
    protected $fillable = [
        'career_level',
        'monthly_token_allocation',
        'max_token_send_to_same_user',
    ];

    protected $appends = [
        'head_count',
    ];

    public function getHeadCountAttribute()
    {
        return User::where('career_level', $this->attributes['career_level'])->count();
    }
}
