<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdmHeader extends Model
{
    
    protected $table = "edm_header";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
}
