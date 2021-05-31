<?php

namespace App\Repositories;

use App\Models\UserLevel;
use Takaworx\Brix\Traits\RepositoryTrait;

class UserLevelRepository extends UserLevel
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'user_levels';
}
