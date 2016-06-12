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
    'user' => [
      'method' => 'get',
      'url' => '/api/users',
      'callback' => [
        'controller' => '\Skeleton\Controller\UserController',
        'function' => 'fetch'
      ]
    ],
];
