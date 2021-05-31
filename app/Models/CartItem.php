<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'user_id',
        'inventory_id',
        'quantity',
    ];

    protected $with = [
        'inventory',
    ];

    protected $appends = [
        'total',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function getTotalAttribute()
    {
        $inventory = $this->inventory()->first();

        return $this->attributes['quantity'] * $inventory->unit_price;
    }
}
