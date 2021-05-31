<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Illuminate\Database\Eloquent\Model;
use Takaworx\Brix\Traits\AuditTrait;

class BlacklistLog extends Model
{
    use AuditTrait, PagerTrait;

    protected $fillable = [
        'created_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'blacklist_logs_users')->withTrashed();
    }
}
