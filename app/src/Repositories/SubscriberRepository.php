<?php

namespace App\Repository;

use App\Config\CacheConfig;
use App\Models\Subscriber;
use App\Models\Status;
use App\Connection\DatabaseConnection;
use App\Connection\CacheConnection;
use App\Repositories\StatusRepository;
use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\DatabaseException;

class SubscriberRepository
{
    private $db;
    private $cache;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
        $this->cache = CacheConnection::getInstance()->getConnection();
    }

    /**
     * Retrieves a paginated list of all subscribers.
     *
     * This method retrieves all subscribers from the database, along with their associated status information.
     * The results are paginated according to the provided page number and page size.
     * Each row of data is mapped to a Subscriber object.
     *
     * @param int $page The page number to retrieve. Page numbers start at 1.
     * @param int $pageSize The number of subscribers to retrieve per page.
     * @return array An array of Subscriber objects for the requested page.
     * @throws DatabaseException If there is an error executing the database query.
     */
    public function getAll($page, $pageSize)
    {
        try {
            $stmt = $this->db->prepare("SELECT s.*, st.name as status_name, st.id as status_id FROM subscribers s
                                        LEFT JOIN statuses st ON s.status_id = st.id
                                        LIMIT :offset, :limit");
            $offset = ($page - 1) * $pageSize;
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindParam(':limit', $pageSize, \PDO::PARAM_INT);
            $stmt->execute();
            $subscribersData = $stmt->fetchAll();

            $subscribers = [];
            foreach ($subscribersData as $subscriberData) {
                $subscribers[] = $this->mapDataToSubscriber($subscriberData);
            }
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 500, $e);
        }

        return $subscribers;
    }

    /**
     * Retrieves a subscriber by ID.
     *
     * @param int $id The ID of the subscriber.
     * @return Subscriber|null The subscriber, or null if the subscriber was not found.
     */
    public function getById($id)
    {
        $cacheKeyId = CacheConfig::SUBSCRIBER_ID_KEY . $id;
        $subscriber = $this->cache->get($cacheKeyId);

        if ($subscriber === false) {
            try {
                $query = "SELECT s.*, st.id, as status_id, st.name as status_name FROM subscribers s
                LEFT JOIN statuses st ON s.status_id = st.id
                WHERE s.id = :id";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch();

                if ($data === false) {
                    return null;
                }

                $subscriber = $this->mapDataToSubscriber($data);
                $cacheKeyEmail = CacheConfig::SUBSCRIBER_ID_KEY . $subscriber->getEmail();

                // Populate associative cache
                $this->cache->set($cacheKeyId, json_encode($data));
                $this->cache->set($cacheKeyEmail, $id);

                return $subscriber;
            } catch (\PDOException $e) {
                throw new DatabaseException($e->getMessage(), 500, $e);
            }
        }

        return $subscriber;
    }


    /**
     * Retrieves a subscriber by ID.
     *
     * @param int $id The ID of the subscriber.
     * @return Subscriber|null The subscriber, or null if the subscriber was not found.
     */
    public function getByEmail($email)
    {
        $email = strtolower($email);
        $cacheKeyEmail = CacheConfig::SUBSCRIBER_EMAIL_KEY . $email;
        $subscriberId = $this->cache->get($cacheKeyEmail);

        // If the subscriber ID was found in the cache, try to get the subscriber data
        if ($subscriberId !== false) {
            $cacheKeyId = CacheConfig::SUBSCRIBER_ID_KEY . $subscriberId;
            $subscriberData = json_decode($this->cache->get($cacheKeyId), true);

            if ($subscriberData !== false) {
                return $this->mapDataToSubscriber($subscriberData);
            }
        }

        // If the subscriber was not found in the cache, retrieve it from the database
        try {
            $stmt = $this->db->prepare("SELECT s.*, st.name as status_name, st.id as status_id FROM subscribers s
                                        LEFT JOIN statuses st ON s.status_id = st.id
                                        WHERE s.email = :email");
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();
            $subscriberData = $stmt->fetch();

            if ($subscriberData === false) {
                return null;
            }

            $subscriber = $this->mapDataToSubscriber($subscriberData);
            $cacheKeyId = CacheConfig::SUBSCRIBER_ID_KEY . $subscriberId;

            // Store the subscriber ID and data in the cache
            $this->cache->set($cacheKeyId, json_encode($subscriberData));
            $this->cache->set($cacheKeyEmail, $subscriber['id']);
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 500, $e);
        }

        return $subscriber;
    }

    /**
     * Creates a new subscriber in the database.
     *
     * @param Subscriber $subscriber The subscriber to create
     * @throws DatabaseException If there is an error executing the database queries.
     */
    public function create(Subscriber $subscriber)
    {
        try {
            $this->db->beginTransaction();

            $email = strtolower($subscriber->getEmail());

            // Check if exists a subscriber with the provided email.
            $stmt = $this->db->prepare("SELECT * FROM subscribers WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $existingSubscriber = $stmt->fetch();

            if ($existingSubscriber === false) {

                // Check if exists a status with the provided status_id.
                $stmt = $this->db->prepare("SELECT * FROM statuses WHERE id = :status_id");
                $stmt->bindParam(':status_id', $subscriber->getStatus()->getId());
                $stmt->execute();
                $status = $stmt->fetch();

                if ($status === false) {
                    throw new DatabaseException(ErrorCode::INVALID_STATUS_ID['message'], 500);
                }

                $stmt = $this->db->prepare("INSERT INTO subscribers (email, name, last_name, status_id)
                    VALUES (:email, :name, :last_name, :status_id)");
                $stmt->bindParam(':email', $subscriber->getEmail());
                $stmt->bindParam(':name', $subscriber->getName());
                $stmt->bindParam(':last_name', $subscriber->getLastName());
                $stmt->bindParam(':status_id', $subscriber->status->getId());
                $stmt->execute();
            }

            $this->db->commit();
        } catch (\PDOException $e) {
            $this->db->rollBack();
            throw new DatabaseException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Maps raw database data to a Subscriber object.
     *
     * @param array $data The raw data from the database, typically a row from a SELECT query.
     * @return Subscriber A Subscriber object containing the data from the provided array.
     */
    private function mapDataToSubscriber($data)
    {
        $status = StatusRepository::mapDataToStatus($data);
        return new Subscriber(
            $data['email'],
            $data['name'],
            $data['last_name'],
            $status
        );
    }
}
