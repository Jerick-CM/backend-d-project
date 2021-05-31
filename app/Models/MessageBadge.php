<?php

namespace App\Models;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageBadge extends Model
{
    use EloquentJoin, SoftDeletes;
    


    protected $table = "message_badges";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;



    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'type',
    ];

    protected $with = [
        'badge',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'type');
    }
}
