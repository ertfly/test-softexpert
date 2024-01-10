<?php

return [
    \App\Middlewares\NoTokenMiddleware::class => [
        \App\Modules\TokenController::class => [
            'post:/token' => 'post'
        ],
    ],
];
