<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Takaworx\Brix\Traits\AuditTrait;

class InventoryLog extends Model
{
    use AuditTrait;
    
    const TYPE_DEBIT  = 0;
    const TYPE_CREDIT = 1;

    protected $table = 'inventory_logs';

    protected $fillable = [
        'inventory_id',
        'action',
        'amount',
        'is_sale',
    ];
}
