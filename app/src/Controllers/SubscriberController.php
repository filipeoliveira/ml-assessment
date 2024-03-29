<?php

namespace App\Controllers;

use App\Models\Subscriber;
use App\Services\SubscriberService;
use App\Utilities\Validation\Validator;
use App\Utilities\Errors\ErrorCode;
use App\Utilities\Http;

class SubscriberController
{
    private $subscriberService;
    private $http;

    /**
     * SubscriberController constructor.
     *
     * Initializes a new instance of the SubscriberService.
     */
    public function __construct(Http $http, SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
        $this->http = $http;
    }

    /**
     * Retrieves all subscribers with pagination.
     *
     * The page number and page size are retrieved from the query parameters througgh getPaginationParameters.
     * If these parameters are not present or are not valid integers, default values are used.
     *
     * @return JSON encoded string response containing the subscribers.
     */
    public function getAll()
    {
        list($page, $pageSize) = $this->http->getPaginationParameters();

        $subscribers = $this->subscriberService->getAll($page, $pageSize);
        return $this->http->response($subscribers);
    }

    /**
     * Retrieves a subscriber by email.
     *
     * @return JSON encoded string response The response.
     */
    public function getByEmail($email)
    {
        // Validate the parameters in the request
        $rules = [
            'email' => ['required', 'email', 'length:255'],
        ];
        $request['email'] = $email;
        Validator::validate($request, $rules);
        $subscriber = $this->subscriberService->getByEmail($request['email']);

        if ($subscriber) {
            return $this->http->response($subscriber, 200);
        }

        return $this->http->response(ErrorCode::SUBSCRIBER_NOT_FOUND, 404);
    }


    /**
     * Creates a new subscriber.
     *
     * The request parameters are validated to ensure that 'email' is present and is a valid email address.
     * If the parameters are not valid, a validation error is thrown.
     * If a subscriber with the same email already exists, no action is taken.
     * Otherwise, a new subscriber is created.
     *
     * @return JSON encoded string response containg the new subscriber or an error.
     */
    public function create()
    {
        // Validate the parameters in the request
        $rules = [
            'email' => ['required', 'email', 'length:255'],
            'name' => ['required', 'string', 'length:255'],
            'last_name' => ['required', 'string', 'length:255'],
            'status' => ['required', 'string', 'length:255'],
        ];

        $data = $this->http->parsePostData($_SERVER['CONTENT_TYPE']);
        Validator::validate($data, $rules);

        // Create the subscriber
        $subscriber = new Subscriber($data['email'], $data['name'], $data['last_name'], $data['status']);


        $isNewSubscriber = $this->subscriberService->create($subscriber);

        if ($isNewSubscriber) {
            return $this->http->response($subscriber, 201);
        }

        return $this->http->response(ErrorCode::SUBSCRIBER_ALREADY_EXISTS, 200);
    }
}
