<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $appends = [
        'image_url',
    ];
    
    public function getImageUrlAttribute()
    {
        return secure_url("img/badges/{$this->attributes['id']}.png");
    }
}
