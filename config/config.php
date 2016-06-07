<?php
return [
    'settings' => [
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
                'dbname' => 'slim_skeleton',
                'user' => 'root',
                'password' => '2961835'
            ]
        ],
        'twig' => [
            'view_path' => APPPATH . '/app/views',
            'settings' => [
                'path' => APPPATH . '/cache',
                'auto_reload' => true
            ]
        ]
    ]
];