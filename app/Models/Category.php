<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use PagerTrait;

    protected $fillable = [
        'name',
    ];
}
