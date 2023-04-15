<?php

return [
    'test' => [
        'admins' => [
            'key' => 'test:admins',
            'type' => 'string',
            'ttl' => 300,
        ],
        'roles' => [
            'key' => 'test:roles',
            'type' => 'string',
            'ttl' => 300,
        ],
    ],

    'counter' => [
        'user_uid' => 'counter:user_uid',
    ],
];
