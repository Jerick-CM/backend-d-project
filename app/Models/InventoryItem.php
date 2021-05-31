<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Takaworx\Brix\Traits\UidTrait;

class InventoryItem extends Model
{
    use UidTrait;
    
    protected $table = 'inventory_items';
}
