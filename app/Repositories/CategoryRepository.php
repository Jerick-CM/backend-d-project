<?php

namespace App\Repositories;

use App\Models\Category;
use Takaworx\Brix\Traits\RepositoryTrait;

class CategoryRepository extends Category
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'categories';
}
