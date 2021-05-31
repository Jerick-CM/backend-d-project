<?php

namespace App\Repositories;

use App\Models\Position;
use Takaworx\Brix\Traits\RepositoryTrait;

class PositionRepository extends Position
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'positions';
}
