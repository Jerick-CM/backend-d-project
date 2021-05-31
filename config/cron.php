<?php

return [
    'send_welcome' => env('CRON_SEND_WELCOME'),
    'send_welcome_email' => env('CRON_SEND_WELCOME_EMAIL', true),
    'send_welcome_amount' => env('CRON_SEND_WELCOME_AMOUNT', 0),
    'sync_users' => env('CRON_SYNC_USERS'),
    'sync_users_country' => env('CRON_SYNC_USERS_COUNTRY'),
    'sync_partners' => env('CRON_SYNC_PARTNERS', 'Partner'),
    'sync_pseudo_partners' => env('CRON_SYNC_PSEUDO_PARTNERS', 'Lead Director'),
    'sync_interns' => env('CRON_SYNC_INTERNS', 'Intern'),
    'sync_exclude_departments' => env('CRON_SYNC_EXCLUDE_DEPARTMENTS', null),
    'tokens' => [
        'distribute' => env('CRON_SEND_BLACK_TOKENS_QUARTERLY', true),
        'audit' => env('CRON_AUDIT_TOKENS_DAILY', true),
        'test'  => env('CRON_SEND_BLACK_TOKENS_TEST', false),
        'expiredaily' => env('CRON_GREEN_TOKEN_EXPIRE_DAILY', false),
        'expiremonthly' => env('CRON_GREEN_TOKEN_EXPIRE_MONTHLY', false)
    ],
    'send_monthly_summary' => env('CRON_SEND_MONTHLY_SUMMARY', false),
];
