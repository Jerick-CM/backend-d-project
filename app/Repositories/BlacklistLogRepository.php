<?php

namespace App\Repositories;

use App\Models\BlacklistLog;
use Takaworx\Brix\Traits\RepositoryTrait;

class BlacklistLogRepository extends BlacklistLog
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'blacklist_logs';
}
