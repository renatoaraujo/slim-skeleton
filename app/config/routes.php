<?php
return [
    'home' => [
        'method' => 'get',
        'url' => '/',
        'callback' => [
            'controller' => '\Skeleton\Controller\HomeController',
            'function' => 'renderHomePage',
        ],
    ],
    'signin' => [
        'method' => 'get',
        'url' => '/signin',
        'callback' => [
            'controller' => '\Skeleton\Controller\SigninController',
            'function' => 'renderSigninPage'
        ]
    ],
    'signup' => [
        'method' => 'get',
        'url' => '/signup',
        'callback' => [
            'controller' => '\Skeleton\Controller\SignupController',
            'function' => 'renderSignupPage'
        ]
    ],
    'signup-post' => [
        'method' => 'post',
        'url' => '/signup',
        'callback' => [
            'controller' => '\Skeleton\Controller\SignupController',
            'function' => 'signupFormAction'
        ]
    ],
    'development' => [
        'method' => 'get',
        'url' => '/development',
        'callback' => [
            'controller' => '\Skeleton\Controller\DevelopmentController',
            'function' => 'renderDevelopmentPage'
        ]
    ],
    'getUsersApi' => [
        'method' => 'get',
        'url' => '/api/users',
        'callback' => [
            'controller' => '\Skeleton\Controller\UserController',
            'function' => 'fetch',
        ],
    ],
    'getUserApi' => [
        'method' => 'get',
        'url' => '/api/users/{pubUniqueId}',
        'callback' => [
            'controller' => '\Skeleton\Controller\UserController',
            'function' => 'fetchOne',
        ],
    ],
];
