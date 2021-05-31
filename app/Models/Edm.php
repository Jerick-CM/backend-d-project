<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Illuminate\Database\Eloquent\Model;

class Edm extends Model
{
    use PagerTrait;

    const TYPE_NOMINATION_SENDER = 1;
    const TYPE_NOMINATION_RECIPIENT = 2;
    const TYPE_REDEEM = 3;
    const TYPE_WELCOME = 4;
    const TYPE_NOMINATION_SENDER_TOKEN = 5;
    const TYPE_NOMINATION_RECIPIENT_TOKEN = 6;
    const TYPE_MONTHLY_SUMMARY = 7;
    const TYPE_TIER_PROMOTION = 8;
    const TYPE_UNIVERSAL_EMAIL = 9;
    const TYPE_MASSTOKENUPDATE_EMAIL = 10;
    const TYPE_ADMINLOG_EMAIL = 11;

    protected $table = 'edm';

    protected $fillable = [
        'name',
    ];
}
