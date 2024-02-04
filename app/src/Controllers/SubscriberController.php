<?php

namespace App\Controllers;

use App\Models\Subscriber;
use App\Utilities\Validation\Validator;
use App\Utilities\Errors\ErrorCode;
use Pimple\Container;

class SubscriberController
{
    private $subscriberService;

    /**
     * SubscriberController constructor.
     *
     * Initializes a new instance of the SubscriberService.
     */
    public function __construct(Container $container)
    {
        $this->subscriberService = $container['subscriberService'];
    }

    /**
     * Retrieves all subscribers with pagination.
     *
     * The page number and page size are retrieved from the query parameters.
     * If these parameters are not present or are not valid integers, default values are used.
     * Default value for 'page' is 0 and for 'pageSize' is 25.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the subscribers.
     */
    public function getAll()
    {
        list($page, $pageSize) = getPaginationParameters();

        $subscribers = $this->subscriberService->getAll($page, $pageSize);
        return response()->json($subscribers);
    }

    /**
     * Retrieves a subscriber by email.
     *
     * @return \Illuminate\Http\JsonResponse The response.
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
            return response()->json($subscriber, 200);
        }

        return response()->json(ErrorCode::SUBSCRIBER_NOT_FOUND, 404);
    }


    /**
     * Creates a new subscriber.
     *
     * The request parameters are validated to ensure that 'email' is present and is a valid email address.
     * If the parameters are not valid, a validation error is thrown.
     * If a subscriber with the same email already exists, no action is taken.
     * Otherwise, a new subscriber is created.
     *
     * @return \Illuminate\Http\JsonResponse The response.
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

        $data = parsePostData($_SERVER['CONTENT_TYPE']);
        Validator::validate($data, $rules);

        // Create the subscriber
        $subscriber = new Subscriber($data['email'], $data['name'], $data['last_name'], $data['status']);
        $isNewSubscriber = $this->subscriberService->create($subscriber);

        if ($isNewSubscriber) {
            return response()->json($subscriber, 201);
        }

        return response()->json(ErrorCode::SUBSCRIBER_ALREADY_EXISTS, 200);
    }
}
