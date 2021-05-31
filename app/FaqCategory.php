<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
	
    protected $table = "faq_categories";

    // Primary Key

    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
}
