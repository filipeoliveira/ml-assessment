<?php

namespace App\Controller;

use App\Models\Subscriber;
use App\Service\SubscriberService;
use App\Utilities\Errors\ErrorCode;
use App\Utilities\Validation\Validator;
use App\Service\StatusService;

class SubscriberController
{
    private $subscriberService;
    private $statusService;

    /**
     * SubscriberController constructor.
     *
     * Initializes a new instance of the SubscriberService.
     */
    public function __construct()
    {
        $this->subscriberService = new SubscriberService();
        $this->statusService = new StatusService();
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
     * Retrieves a subscriber by ID.
     *
     * The ID is validated to be a required integer value.
     * If the ID is not valid, a validation error is thrown.
     * If the subscriber is not found, a 404 error is returned.
     *
     * @param array $request The request parameters.
     * @return \Illuminate\Http\JsonResponse The response.
     */
    public function getById()
    {
        $request = $_GET;
        $rules = [
            'id' => [
                "required", "integer"
            ],
        ];
        Validator::validate($request, $rules);
        $id = $_GET["id"];
        $subscriber = $this->subscriberService->getById($id);

        if ($subscriber === null) {
            return response()->json(['error' => ErrorCode::SUBSCRIBER_NOT_FOUND], 404);
        }

        return response()->json($subscriber);
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
            'email' => ['required', 'email'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'status_id' => ['exists:statuses,id'],
        ];
        $request = $_POST;
        Validator::validate($request, $rules);

        // Create the subscriber
        $status = $this->statusService->getById($request['status_id']);
        $subscriber = new Subscriber($request['email'], $request['name'], $request['last_name'], $status);

        $isNewSubscriber = $this->subscriberService->create($subscriber);

        if ($isNewSubscriber) {
            return response()->json($subscriber, 201);
        }

        return response()->json(['message' => 'Subscriber already exists'], 200);
    }
}
