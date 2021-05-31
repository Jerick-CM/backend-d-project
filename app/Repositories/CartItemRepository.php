<?php

namespace App\Repositories;

use App\Models\CartItem;
use Takaworx\Brix\Traits\RepositoryTrait;

class CartItemRepository extends CartItem
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'cart_items';

    public function clear($userID)
    {
        return $this->where('user_id', $userID)->forceDelete();
    }
}
