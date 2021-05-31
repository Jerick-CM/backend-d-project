<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "pages";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
}
