<?php

return [
    'welcome' => [
        'navigation_link' => env('EDM_WELCOME_NAVIGATION_LINK'),
        'ace_link' => env('EDM_WELCOME_ACE_LINK'),
    ],
    'redeem' => [
        'history_link' => env('EDM_REDEEM_HISTORY_LINK'),
        'faq_link' => env('EDM_REDEEM_FAQ_LINK'),
    ],
    'collection' => [
        'time' => env('COLLECTION_TIME', '15:00'),
    ],
    'monthly_summary' => [
        'ace_store_link' => env('EDM_MONTHLY_SUMMARY_ACE_STORE_LINK'),
        'history_link' => env('EDM_MONTHLY_SUMMARY_HISTORY_LINK'),
    ],
];
