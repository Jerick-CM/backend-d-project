<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use PagerTrait, EloquentJoin, SoftDeletes;

    protected $fillable = [
        'name',
        'short_name',
        'monthly_token_allocation',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }
}
