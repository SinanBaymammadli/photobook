<?php

return [
    'role_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'photos' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'admin' => [
            'users' => 'c,r,u',
            'photos' => 'r',
            'profile' => 'r,u',
        ],
        'user' => [
            'profile' => 'r,u',
            'photos' => 'c,r',
        ],
    ],
    'permission_structure' => [],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
