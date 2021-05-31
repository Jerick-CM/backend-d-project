<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdmCsvMassUpload extends Model
{
    
    protected $table = "csv_massuploadtoken";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;
}
