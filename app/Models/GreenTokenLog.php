<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GreenTokenLog extends Model
{
    const ACTION_DEBIT  = 0;
    const ACTION_CREDIT = 1;

    const TYPE_NOMINATION = 0;
    const TYPE_REDEEM     = 1;
    const TYPE_ADMIN_OVERRIDE = 2;
    const TYPE_EXPIRED = 3;

    protected $fillable = [
        'user_id',
        'action',
        'type',
        'amount',
        'created_by',
        'remarks',
        'is_pruned',
        'expires_at',
    ];

    public function setExpiresAtAttribute($value)
    {
        if (! is_null($value)) {
            $this->attributes['expires_at'] = $value;
        }

        if ($this->attributes['action'] === self::ACTION_DEBIT) {
            $this->attributes['expires_at'] = $value;
        }

        $this->attributes['expires_at'] = Carbon::now()->addDays(365)->toDateString();
    }
}
