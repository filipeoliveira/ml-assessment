<?php

namespace App\Service;

use App\Repository\SubscriberRepository;
use App\Models\Subscriber;

class SubscriberService
{
    private $subscriberRepository;

    /**
     * SubscriberService constructor.
     *
     * Initializes a new instance of the SubscriberRepository.
     */
    public function __construct()
    {
        $this->subscriberRepository = new SubscriberRepository();
    }

    /**
     * Retrieves all subscribers with pagination.
     *
     * @param int $page The page number (default is 0).
     * @param int $pageSize The number of items per page (default is 25).
     * @return array The subscribers.
     */
    public function getAll($page = 0, $pageSize = 25)
    {
        return $this->subscriberRepository->getAll($page, $pageSize);
    }

    /**
     * Retrieves a subscriber by ID.
     *
     * @param int $id The ID of the subscriber.
     * @return array|null The subscriber, or null if the subscriber was not found.
     */
    public function getbyId($id)
    {
        return $this->subscriberRepository->getbyId($id);
    }

    /**
     * Creates a subscriber.
     *
     * If a subscriber with the same email already exists, no action is taken.
     * Otherwise, a new subscriber is created.
     *
     * @param Subscriber $subscriber The subscriber to write.
     * @return bool True if a new subscriber was created, false otherwise.
     */
    public function create(Subscriber $subscriber)
    {
        $email = $subscriber->getEmail();
        $existingSubscriber = $this->subscriberRepository->getByEmail($email);

        if ($existingSubscriber === null) {
            $this->subscriberRepository->create($subscriber);
            return true;
        }

        return false;
    }
}
