<?php
return [
  'home' => [
    'method' => 'get',
    'url' => '/',
    'callback' => [
      'controller' => '\Skeleton\Controller\HomeController',
      'function' => 'testing',
    ],
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
