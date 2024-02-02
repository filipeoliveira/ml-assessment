<?php

use App\Controller\SubscriberController;

return [
    'api/subscribers' => [
        'GET' => [SubscriberController::class, 'getAllSubscribers'],
        'POST' => [SubscriberController::class, 'createSubscriber'],
    ],
    'api/subscribers/{id}' => [
        'GET' => [SubscriberController::class, 'getSubscriber'],
        'PUT' => [SubscriberController::class, 'updateSubscriber'],
        'DELETE' => [SubscriberController::class, 'deleteSubscriber'],
    ]
];
