<?php

namespace App\Models;

use App\Helpers\CollectionHelper;
use App\Traits\PagerTrait;
use Carbon\Carbon;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Redeem extends Model
{
    use PagerTrait, EloquentJoin, SoftDeletes;
    
    protected $table = 'redeems';

    protected $fillable = [
        'user_id',
        'quantity',
        'total_credits',
        'collection_date',
    ];

    protected $appends = [
        'redeem_items',
        'order_number',
    ];

    protected $foreignProperties = [
        'user_name' => 'user|users.name',
        'position_name' => 'user|user.position|positions.name',
        'department_name' => 'user|user.department|departments.name',
    ];

    /**
     * An item in the transaction
     *
     * @return RedeemTransaction
     */
    public function redeemTransactions()
    {
        return $this->hasMany(RedeemTransaction::class, 'redeem_id');
    }

    /**
     * The user involved in the transaction
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * All items in the transction
     *
     * @return Collection
     */
    public function getRedeemItemsAttribute()
    {
        return $this->redeemTransactions()->get();
    }

    /**
     * The id of the order padded with 0s
     *
     * @return string
     */
    public function getOrderNumberAttribute()
    {
        return str_pad($this->attributes['id'], 10, '0', STR_PAD_LEFT);
    }

    public static function boot()
    {
        self::creating(function ($table) {
            $table->collection_date = CollectionHelper::getNextCollectionDate();
        });
    }
}
