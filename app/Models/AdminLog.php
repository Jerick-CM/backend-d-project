<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use PagerTrait, EloquentJoin;

    const TYPE_BANNER_CREATE = 0;
    const TYPE_BANNER_UPDATE = 1;
    const TYPE_BANNER_DELETE = 2;

    const TYPE_EDM_UPDATE = 3;

    const TYPE_REWARDS_CREATE = 4;
    const TYPE_REWARDS_UPDATE = 5;
    const TYPE_REWARDS_CREDIT = 6;
    const TYPE_REWARDS_DEBIT  = 7;

    const TYPE_USER_UPDATE = 8;
    const TYPE_USER_TOKEN  = 9;
    const TYPE_USER_BLOCK  = 10;

    const TYPE_ADMIN_ACCESS_GRANTED = 11;
    const TYPE_ADMIN_ACCESS_REVOKED = 12;
    const TYPE_PORTAL_ACCESS_GRANTED = 13;
    const TYPE_PORTAL_ACCESS_REVOKED = 14;

    const TYPE_DOWNLOAD_LOG = 15;

    const TYPE_USER_TOKEN_TRANSFER = 1000;
    const TYPE_USER_TOKEN_DEDUCT = 1001;

    const TYPE_USER_TOKEN_TRANSFER_RECOGNIZE = 1010;
    const TYPE_USER_TOKEN_DEDUCT_RECOGNIZE = 1011;



    const TYPE_USER_LEVEL_ALLOWANCE_INCREASE = 1100;
    const TYPE_USER_LEVEL_ALLOWANCE_DECREASE = 1101;
    const TYPE_USER_LEVEL_SEND_LIMIT_INCREASE = 1102;
    const TYPE_USER_LEVEL_SEND_LIMIT_DECREASE = 1103;

    const TYPE_CAROUSEL_HOME_NEW = 1300;
    const TYPE_CAROUSEL_HOME_UPDATE_LINK = 1301;
    const TYPE_CAROUSEL_HOME_UPDATE_TITLE = 1302;
    const TYPE_CAROUSEL_STORE_NEW = 1303;
    const TYPE_CAROUSEL_STORE_UPDATE_LINK = 1304;
    const TYPE_CAROUSEL_STORE_UPDATE_TITLE = 1305;

    const TYPE_INVENTORY_NEW = 1400;
    const TYPE_INVENTORY_UPDATE_NAME = 1401;
    const TYPE_INVENTORY_UPDATE_DP = 1402;
    const TYPE_INVENTORY_UPDATE_PRICE = 1403;
    const TYPE_INVENTORY_UPDATE_DISCONTINUE = 1404;
    const TYPE_INVENTORY_UPDATE_PREORDER = 1405;
    const TYPE_INVENTORY_UPDATE_META = 1406;

    const TYPE_ADMIN_DOWNLOAD_RECORD = 1500;

    const TYPE_ADMIN_DOWNLOAD_X_RECORD = 1510;

    const TYPE_CMS_FAQ_EDIT = 2000;
    const TYPE_CMS_FAQ_ADD = 2001;
    const TYPE_CMS_FAQ_SORT = 2002;
    const TYPE_CMS_FAQ_DELETE = 2003;
    const TYPE_CMS_FAQ_DELETEDMANYOPTION = 2004;
    //resever 2005 - 2019

    const TYPE_CMS_FAQ_CATEGORY_EDIT = 2020;
    const TYPE_CMS_FAQ_CATEGORY_ADD = 2021;
    const TYPE_CMS_FAQ_CATEGORY_SORT = 2022;
    const TYPE_CMS_FAQ_CATEGORY_DELETE = 2023;
    const TYPE_CMS_FAQ_CATEGORY_DELETEDMANYOPTION = 2024;
    //resever 2025 - 2039

    const TYPE_CMS_FAQ_UPLOAD = 2040;

    const TYPE_CMS_PAGE_EDIT = 2050;
    const TYPE_CMS_PAGE_ADD = 2051;
    const TYPE_CMS_PAGE_SORT = 2052;
    const TYPE_CMS_PAGE_DELETE = 2053;
    const TYPE_CMS_PAGE_DELETEDMANYOPTION = 2054;


    const TYPE_POSTMESSAGE_AND_SENDTOKEN = 2060;

    const TYPE_DELETE_MESSAGES = 2068;
    const TYPE_DELETE_BADGE = 2069;

    const TYPE_REMOVERETAIN_REMOVE_BADGES = 2070;
    const TYPE_REMOVERETAIN_RETAIN_BADGES = 2071;
    const TYPE_REMOVERETAIN_REMOVE_TOKEN = 2072;
    const TYPE_REMOVERETAIN_RETAIN_TOKEN = 2073;
    const TYPE_POST_REFUND_TOKEN = 2074;

    const TYPE_UPDATE_TIER = 2075;
    const TYPE_PROMOTION_REWARDSTOKEN =  2076;
    const TYPE_BADGE_REWARDSTOKEN  = 2077;

    const TYPE_EDM_FOOTER_EDIT = 2080;
    const TYPE_EDM_HEADER_EDIT = 2081;
    const TYPE_EDM_TEMPLATE_BODY = 2082;

    const TYPE_EDM_SENT_EMAIL = 2083;
    const TYPE_EDM_RECEIVE_EMAIL = 2084;
    const TYPE_EDM_WELCOME_EMAIL = 2085;
    const TYPE_EDM_REDEMPTION_EMAIL = 2086;
    const TYPE_EDM_MONTHLYREPORT_EMAIL = 2087;
    const TYPE_EDM_TIERPROMOTION_EMAIL = 2088;
    const TYPE_EDM_TEMPLATE_BODY_CREATE = 2089;
    const TYPE_EDM_TEMPLATE_BODY_DELETE = 2090;
    const TYPE_EDM_SENTLOGS_DOWNLOAD = 2091;
    const TYPE_EDM_MASSTOKENUPLOAD = 2092;

    const TYPE_ADMINLOG_EMAIL   = 2093;

    protected $fillable = [
        'user_id',
        'type',
        'meta',
    ];

    protected $with = [
        'user',
    ];

    protected $appends = [
        'description',
    ];

    protected $foreignProperties = [
        'user_name' => 'user|users.name',
    ];

    /**
     * Get user of log
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function getMetaAttribute($value)
    {
        return json_decode($value);
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode($value);
    }

    public function getDescriptionAttribute()
    {
        switch ($this->attributes['type']) {
            case 0:
                $result = __('adminLogs.banner.create', json_decode($this->attributes['meta'], true));
                break;
            case 1:
                $result = __('adminLogs.banner.update', json_decode($this->attributes['meta'], true));
                break;
            case 2:
                $result = __('adminLogs.banner.delete', json_decode($this->attributes['meta'], true));
                break;
            case 3:
                $result = __('adminLogs.edm.update', json_decode($this->attributes['meta'], true));
                break;
            case 4:
                $result = __('adminLogs.rewards.create', json_decode($this->attributes['meta'], true));
                break;
            case 5:
                $result = __('adminLogs.rewards.update', json_decode($this->attributes['meta'], true));
                break;
            case 6:
                $result = __('adminLogs.rewards.credit', json_decode($this->attributes['meta'], true));
                break;
            case 7:
                $result = __('adminLogs.rewards.debit', json_decode($this->attributes['meta'], true));
                break;
            case 8:
                $result = __('adminLogs.users.update', json_decode($this->attributes['meta'], true));
                break;
            case 9:
                $result = __('adminLogs.users.token', json_decode($this->attributes['meta'], true));
                break;
            case 10:
                $result = __('adminLogs.users.block', json_decode($this->attributes['meta'], true));
                break;
            case 11:
                $result = __('adminLogs.access.admin_granted', json_decode($this->attributes['meta'], true));
                break;
            case 12:
                $result = __('adminLogs.access.admin_revoked', json_decode($this->attributes['meta'], true));
                break;
            case 13:
                $result = __('adminLogs.access.portal_granted', json_decode($this->attributes['meta'], true));
                break;
            case 14:
                $result = __('adminLogs.access.portal_revoked', json_decode($this->attributes['meta'], true));
                break;
            case 15:
                $result = __('adminLogs.reports.download_admin_log', json_decode($this->attributes['meta'], true));
                break;
            default:
                $file = "adminLogsDefault.{$this->attributes['type']}";
                $result = __($file, json_decode($this->attributes['meta'], true));
                break;
        }

        return $result;
    }
}
