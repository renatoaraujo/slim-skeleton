<?php
return [
    'home' => [
        'method' => 'get',
        'url' => '/',
        'callback' => [
            'controller' => '\Skeleton\Controller\HomeController',
            'function' => 'testing'
        ]
    ],
    'teste' => [
        'method' => 'get',
        'url' => '/teste',
        'callback' => [
            'controller' => '\Skeleton\Controller\HomeController',
            'function' => 'teste'
        ]
    ],
];