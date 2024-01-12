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
];
