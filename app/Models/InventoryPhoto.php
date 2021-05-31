<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryPhoto extends Model
{
    protected $table = 'inventory_photos';

    protected $fillable = [
        'inventory_id',
        'is_primary',
        'order',
        'file',
    ];

    protected $appends = [
        'file_full',
    ];

    public function getFileAttribute($value)
    {
        if (is_null($value)) {
            $value = 'default.png';
        }

        return secure_url("img/rewards/thumb/$value");
    }

    public function getFileFullAttribute()
    {
        if (is_null($this->attributes['file'])) {
            $value = 'default.png';
        } else {
            $value = $this->attributes['file'];
        }

        return secure_url("img/rewards/full/$value");
    }

    public static function boot()
    {
        self::creating(function ($table) {
            $maxOrderItem = self::where('inventory_id', $table->attributes['inventory_id'])->max('order');

            if (! $maxOrderItem) {
                $table->order = 1;
            } else {
                $table->order = intval($maxOrderItem) + 1;
            }
        });
    }
}
