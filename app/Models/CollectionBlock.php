<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Illuminate\Database\Eloquent\Model;

class CollectionBlock extends Model
{
    use PagerTrait;
    
    protected $fillable = [
        'date',
    ];
}
