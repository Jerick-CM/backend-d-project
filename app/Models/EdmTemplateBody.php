<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EdmTemplateBody extends Model
{
    
    use SoftDeletes;
    
    protected $table = "edm_template_body";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
}
