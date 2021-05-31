<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageToken extends Model
{


    protected $table = "message_tokens";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;


    use SoftDeletes;
    
    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'amount',
    ];

    public static function boot()
    {
        parent::boot();
        
        self::creating(function ($table) {
            $table->expires_at = Carbon::now()->addDays(365)->toDateString();
        });
    }
}
