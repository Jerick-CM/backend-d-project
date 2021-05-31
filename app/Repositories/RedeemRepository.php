<?php

namespace App\Repositories;

use App\Models\Redeem;
use App\Models\RedeemTransaction;
use Takaworx\Brix\Traits\RepositoryTrait;

class RedeemRepository extends Redeem
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'redeems';

    public function attachTransaction($redeem, $item)
    {
        return RedeemTransaction::create([
            'redeem_id'     => $redeem->id,
            'inventory_id'  => $item->inventory_id,
            'quantity'      => $item->quantity,
            'total_credits' => $item->quantity * $item->inventory->unit_price,
        ]);
    }
}
