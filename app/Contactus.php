<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    protected $table = "contactus";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
}
