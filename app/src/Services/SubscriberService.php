<?php

namespace App\Services;

use App\Repositories\SubscriberRepository;
use App\Models\Subscriber;

class SubscriberService
{
    private $subscriberRepository;

    /**
     * SubscriberService constructor.
     *
     * Initializes a new instance of the SubscriberRepository.
     */
    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Retrieves all subscribers with pagination.
     *
     * @param int $page The page number (default is 0).
     * @param int $pageSize The number of items per page (default is 10).
     * @return array The subscribers along with pagination metadata.
     */
    public function getAll($page = 0, $pageSize = 10)
    {
        return $this->subscriberRepository->getAll($page, $pageSize);
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

    /**
     * Retrieves a subscriber by email.
     *
     * @param string $email The email of the subscriber.
     * @return Subscriber|null The subscriber, or null if no subscriber was found.
     */
    public function getByEmail($email)
    {
        return $this->subscriberRepository->getByEmail($email);
    }
}
