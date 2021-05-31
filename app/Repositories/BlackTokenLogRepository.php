<?php

namespace App\Repositories;

use App\Events\BlackTokenLogEvent;
use App\Models\BlackTokenLog;
use Takaworx\Brix\Traits\RepositoryTrait;

class BlackTokenLogRepository extends BlackTokenLog
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'black_token_logs';

    /**
     * Create a black token log and emit a send event
     *
     * @param array $data
     * @return BlackTokenLog
     */
    public function send($data)
    {
        event(new BlackTokenLogEvent(
            $data['user_id'],
            BlackTokenLog::ACTION_CREDIT,
            $data['amount']
        ));
    }
}
