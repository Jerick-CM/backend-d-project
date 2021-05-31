<?php

return [
    'banner' => [
        'create' => ':user created banner :title',
        'update' => ':user updated banner :title',
        'delete' => ':user delete banner :title',
    ],
    'edm' => [
        'update' => ':user has updated the email templates',
    ],
    'rewards' => [
        'create' => ':user created inventory item :item',
        'update' => ':user updated inventory item :item',
        'credit' => ':user added stock for inventory item :item',
        'debit'  => ':user reduced stock inventory item :item',
    ],
    'users' => [
        'update' => ':admin updated user :user',
        'token'  => ':admin updated user :user tokens',
        'block'  => ':admin added :user to blacklist',
    ],
    'access' => [
        'admin_granted' => ':admin granted user :user admin access',
        'admin_revoked' => ':admin revoked user :user admin access',
        'portal_granted' => ':admin granted user :user portal access',
        'portal_revoked' => ':admin revoked user :user portal access',
    ],
    'reports' => [
        'download_admin_log' => ':admin has downloaded admin logs',
    ]
];
