<?php

return [
    \App\Middlewares\TokenMiddleware::class => [
        \App\Modules\AuthController::class => [
            'get:/auth' => 'get',
            'post:/auth' => 'post',
            'delete:/auth' => 'delete',
        ],
    ],
    \App\Middlewares\NoTokenMiddleware::class => [
        \App\Modules\TokenController::class => [
            'post:/token' => 'post'
        ],
        \App\Modules\CorsController::class => [
            'options:/{a}' => 'options',
            'options:/{a}/{b}' => 'options',
            'options:/{a}/{b}/{c}' => 'options'
        ],
    ],
    \App\Middlewares\AuthMiddleware::class => [
        \App\Modules\CustomerController::class => [
            'get:/customer' => 'index',
            'get:/customer/{id}' => 'view',
            'post:/customer' => 'post',
            'put:/customer/{id}' => 'put',
            'delete:/customer/{id}' => 'delete',
        ],
        \App\Modules\UserController::class => [
            'get:/user' => 'index',
            'get:/user/{id}' => 'view',
            'post:/user' => 'post',
            'put:/user/{id}' => 'put',
            'delete:/user/{id}' => 'delete',
        ],
        \App\Modules\Product\CategoryController::class => [
            'get:/product/category' => 'index',
            'get:/product/category/select' => 'select',
            'get:/product/category/{id}' => 'view',
            'post:/product/category' => 'post',
            'put:/product/category/{id}' => 'put',
            'delete:/product/category/{id}' => 'delete',
        ],
        \App\Modules\Product\ProductController::class => [
            'get:/product' => 'index',
            'get:/product/{id}' => 'view',
            'post:/product' => 'post',
            'put:/product/{id}' => 'put',
            'delete:/product/{id}' => 'delete',
        ],
    ],
];
