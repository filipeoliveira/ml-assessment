<?php

use App\Controller\SubscriberController;

return [
    'api/subscribers' => [
        'GET' => [SubscriberController::class, 'getAll'],
        'POST' => [SubscriberController::class, 'create'],
    ],
    'api/subscribers/{id}' => [
        'GET' => [SubscriberController::class, 'getById'],
    ]
];
