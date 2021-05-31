<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use PagerTrait;

    const TYPE_MAIN = 0;
    const TYPE_REDEEM = 1;

    const MAX_MAIN_BANNERS = 5;
    const MAX_REDEEM_BANNERS = 5;
    
    protected $fillable = [
        'title',
        'action',
        'file',
        'order',
        'type',
        'is_open_in_new_tab',
    ];

    protected $appends = [
        'file_url',
    ];

    public function getFileUrlAttribute()
    {
        return secure_url("img/banners/{$this->attributes['file']}");
    }

    public static function boot()
    {
        self::creating(function ($table) {
            $maxOrderItem = self::where('type', $table->attributes['type'])->max('order');

            if (! $maxOrderItem) {
                $table->order = 1;
            } else {
                $table->order = intval($maxOrderItem) + 1;
            }
        });
    }
}
