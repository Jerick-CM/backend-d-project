<?php

namespace App\Repositories;

use App\Models\Department;
use Takaworx\Brix\Traits\RepositoryTrait;

class DepartmentRepository extends Department
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'departments';
}
