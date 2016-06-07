<?php
return [
    'doctrine' => [
        'meta' => [
            'entity_path' => [
                APPPATH . '/app/src/Model/Entity'
            ],
            'auto_generate_proxies' => true,
            'proxy_dir' => APPPATH . '/cache/proxies',
            'cache' => null
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'your-db',
            'user' => 'your-user-name',
            'password' => 'your-password'
        ]
    ],
    'settings' => [
        'debug' => true,
        'whoops.editor' => 'sublime'
    ]
];