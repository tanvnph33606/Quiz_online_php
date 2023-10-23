<?php
return [
    // '/' => [
    //     'controller' => 'HomeController',
    //     'action' => 'index',
    //     'middleware' => ['AuthenticateMiddleware']
    // ],
    // '/about' => [
    //     'controller' => 'AboutController',
    //     'action' => 'index',
    //     'middleware' => ['SomeOtherMiddleware']
    // ],
    // '/product' => [
    //     'controller' => 'ProductController',
    //     'action' => 'list',
    //     'middleware' => ['AuthenticateMiddleware', 'AuthorizationMiddleware']
    // ],
    // '/product/{id}' => [
    //     'controller' => 'ProductController',
    //     'action' => 'detail',
    //     'middleware' => ['AuthenticateMiddleware', 'LoggingMiddleware']
    // ],

    'account' => [
        'controller' => 'account',
        'action' => 'login',
        // 'middleware' => ['LoggingMiddleware']
    ],

    //admin
    'admin' => [
        'controller' => 'admin',
        // 'middleware' => ['LoggingMiddleware']
    ],





];
