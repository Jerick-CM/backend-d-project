<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemTransaction extends Model
{
    protected $table = 'redeem_transactions';

    protected $fillable = [
        'redeem_id',
        'inventory_id',
        'quantity',
        'total_credits',
    ];

    protected $with = [
        'inventory',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id')->withTrashed();
    }
}
