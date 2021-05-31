<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use PagerTrait, EloquentJoin;

    protected $fillable = [
        'name',
        'monthly_token_allocation',
        'max_token_send_to_same_user',
    ];

    protected $excludeFromSort = [
        'users_count',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'position_id');
    }
}
