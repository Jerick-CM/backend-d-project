<?php

namespace App\Repositories;

use App\Models\CollectionBlock;
use Takaworx\Brix\Traits\RepositoryTrait;

class CollectionBlockRepository extends CollectionBlock
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'collection_blocks';
}
