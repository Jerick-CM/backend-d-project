<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BlackTokenLog extends Model
{
    use PagerTrait, EloquentJoin;
    
    const ACTION_DEBIT  = 0;
    const ACTION_CREDIT = 1;

    const TYPE_WALL = 0;
    const TYPE_ADMIN_OVERRIDE = 1;
    const TYPE_EXPIRED = 2;


       protected $fillable = [
        'user_id',
        'action',
        'type',
        'amount',
        'created_by',
        'remarks',
        'expires_at',
    ];

    protected $foreignProperties = [
        'user_name' => 'user|users.name',
        'position_name' => 'user|user.position|positions.name',
        'department_name' => 'user|user.department|departments.name',
    ];

    /**
     * The receiving user of the black token
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function setExpiresAtAttribute($value)
    {
        if (! is_null($value)) {
            $this->attributes['expires_at'] = $value;
        }

        if ($this->attributes['action'] === self::ACTION_DEBIT) {
            $this->attributes['expires_at'] = $value;
        }
        $this->attributes['expires_at'] = Carbon::now()->addDays(90)->toDateString();
    }
}
