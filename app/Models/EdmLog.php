<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PagerTrait;
use Takaworx\Brix\Traits\UidTrait;

class EdmLog extends Model
{
    use UidTrait;
    use PagerTrait;

    protected $uidLength = 32;

    protected $fillable = [
        'type',
        'data',
    ];

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }
}
