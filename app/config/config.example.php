<?php
return [
    'settings' => [
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    ROOTPATH . '/app/src/Model/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' => ROOTPATH . '/cache/proxies',
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
            'view_path' => APPPATH . '/views',
            'settings' => [
                'path' => ROOTPATH . '/cache',
                'auto_reload' => true
            ]
        ],
        'monolog' => [
            'log_file_path' => ROOTPATH . '/logs',
            'log_error' => ROOTPATH . '/logs/' . date('Ymd') . '-error-log.log'
        ]
    ]
];
