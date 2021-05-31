<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    
    protected $table = "faqs";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
}
