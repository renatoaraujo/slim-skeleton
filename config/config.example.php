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
                'host' => '',
                'dbname' => '',
                'user' => '',
                'password' => ''
            ]
        ],
        'twig' => [
            'view_path' => APPPATH . '/app/views',
            'settings' => [
                'path' => APPPATH . '/cache',
                'auto_reload' => true
            ]
        ],
        'monolog' => [
            'log_file_path' => APPPATH . '/logs'
        ]
    ]
];