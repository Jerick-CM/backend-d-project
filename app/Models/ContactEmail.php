<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Illuminate\Database\Eloquent\Model;

class ContactEmail extends Model
{
    use PagerTrait;

    protected $fillable = [
        'id',
        'name',
        'type',
        'email',
    ];
}
