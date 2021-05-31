<?php

namespace App\Repositories;

use App\Models\AdminLog;
use Takaworx\Brix\Traits\RepositoryTrait;

class AdminLogRepository extends AdminLog
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'admin_logs';
}
