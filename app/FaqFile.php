<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqFile extends Model
{ 

	protected $table = "faq_files";

    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
    
}
