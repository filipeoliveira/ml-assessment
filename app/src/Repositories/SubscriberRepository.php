<?php

namespace App\Repositories;

use App\Config\CacheConfig;
use App\Models\Subscriber;
use App\Connection\DatabaseConnection;
use App\Connection\CacheConnection;
use App\Utilities\Exceptions\DatabaseException;

class SubscriberRepository
{
    private $db;
    private $cache;

    public function __construct(DatabaseConnection $db, CacheConnection $cache)
    {
        $this->db = $db->getConnection();
        $this->cache = $cache->getConnection();
    }

    /**
     * Retrieves a paginated list of all subscribers.
     *
     * This method retrieves all subscribers from the database.
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

        $page = $page > 1 ? $page : 1;
        $pageSize = $pageSize > 1 ? $pageSize : 1;

        try {
            $stmt = $this->db->prepare("SELECT * FROM subscribers s
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
     * Retrieves a subscriber by Email.
     *
     * @param int $id The Email of the subscriber.
     * @return Subscriber|null The subscriber, or null if the subscriber was not found.
     */
    public function getByEmail($email)
    {
        $email = strtolower($email);
        $cacheKeyEmail = CacheConfig::SUBSCRIBER_EMAIL_KEY . $email;
        $cacheData = $this->cache->get($cacheKeyEmail);

        if ($cacheData !== null) {
            $subscriberData = json_decode($cacheData);
            if ($subscriberData !== null) {
                return $subscriberData;
            }
        }

        // If the subscriber was not found in the cache, retrieve it from the database
        try {
            $stmt = $this->db->prepare("SELECT * FROM subscribers s
                                        WHERE s.email = :email");
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch();

            if ($data === false) {
                return null;
            }

            $subscriber = $this->mapDataToSubscriber($data);

            // Store the subscriber in the cache
            $this->cache->set($cacheKeyEmail, json_encode($subscriber));
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
            $name = $subscriber->getName();
            $lastName = $subscriber->getLastName();
            $status = strtolower($subscriber->getStatus());

            // Check if exists a subscriber with the provided email.
            if (!$this->subscriberExists($email)) {
                $this->insertSubscriber($email, $name, $lastName, $status);
            }

            $this->db->commit();
        } catch (\PDOException $e) {
            $this->db->rollBack();
            throw new DatabaseException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Checks if a subscriber with the given email exists.
     *
     * @param string $email The email to check.
     * @return bool True if the subscriber exists, false otherwise.
     */
    private function subscriberExists($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM subscribers WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Inserts a new subscriber into the database.
     *
     * @param string $email The email of the subscriber.
     * @param string $name The name of the subscriber.
     * @param string $lastName The last name of the subscriber.
     * @param string $status The status of the subscriber.
     */
    private function insertSubscriber($email, $name, $lastName, $status)
    {
        $stmt = $this->db->prepare("INSERT INTO subscribers (email, name, last_name, status)
        VALUES (:email, :name, :last_name, :status)");
        $stmt->execute([
            ':email' => $email,
            ':name' => $name,
            ':last_name' => $lastName,
            ':status' => $status
        ]);
    }

    /**
     * Maps raw database data to a Subscriber object.
     *
     * @param array $data The raw data from the database, typically a row from a SELECT query.
     * @return Subscriber A Subscriber object containing the data from the provided array.
     */
    private function mapDataToSubscriber($data)
    {
        return new Subscriber(
            $data['email'],
            $data['name'],
            $data['last_name'],
            $data['status'],
        );
    }
}
