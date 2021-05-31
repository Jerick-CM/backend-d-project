<?php

namespace App\Models;

use App\Models\InventoryPhoto;
use App\Traits\PagerTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use PagerTrait, EloquentJoin, SoftDeletes;
    
    protected $table = 'inventory';

    protected $fillable = [
        'name',
        'unit_price',
        'stock',
        'is_visible',
        'is_preorder',
        'category_id',
        'description',
        'short_desc',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $with = [
        'categories',
        'inventoryPhotos',
    ];

    protected $appends = [
        'primary_photo',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_inventory', 'inventory_id', 'category_id');
    }

    public function inventoryPhotos()
    {
        return $this->hasMany(InventoryPhoto::class, 'inventory_id')->orderBy('order');
    }

    //////////////// CUSTOM ATTRIBUTES ////////////////

    public function getPrimaryPhotoAttribute()
    {
        $primaryPhoto = $this->inventoryPhotos()
            ->where('is_primary', 1)
            ->first();

        if (is_null($primaryPhoto)) {
            $primaryPhoto = new InventoryPhoto([
                'inventory_id' => $this->attributes['id'],
                'is_primary'   => 1,
                'file'         => 'default.png',
            ]);
        }

        return $primaryPhoto;
    }
}
