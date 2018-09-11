<?php

return [
    'role_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'photos' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u',
            'categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
        ],
        'admin' => [
            'users' => 'r',
            'photos' => 'r',
            'profile' => 'r,u',
            'categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
        ],
        'user' => [
            'profile' => 'r,u',
            'photos' => 'c,r',
            'categories' => 'r',
            'products' => 'r',
            'orders' => 'c',
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
