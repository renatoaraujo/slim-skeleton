<?php
return [
    'home' => [
        'method' => 'get',
        'url' => '/',
        'middleware' => '\Skeleton\Middleware\HomeMiddleware',
        'callback' => [
            'controller' => '\Skeleton\Controller\HomeController',
            'function' => 'testing'
        ]
    ],
];