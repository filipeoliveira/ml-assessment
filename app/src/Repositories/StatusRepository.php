<?php

namespace App\Repositories;

use App\Connection\DatabaseConnection;
use App\Utilities\Exceptions\DatabaseException;
use App\Models\Status;

class StatusRepository
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    /**
     * Retrieves a status by its ID.
     *
     * @param int $id The ID of the status.
     * @return array|null The status, or null if no status with the given ID exists.
     */
    public function getById($id)
    {
        try {

            $query = "SELECT st.id as status_id, st.name as status_name FROM statuses WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);

            $statusData = $stmt->fetch();

            if ($statusData === false) {
                return null;
            }

            return $this->mapDataToStatus($statusData);
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Maps raw database data to a Status object.
     *
     * @param array $data The raw data from the database, typically a row from a SELECT query.
     * @return Status A Status object containing the data from the provided array.
     */
    public static function mapDataToStatus($data)
    {
        return new Status(
            $data['status_id'],
            $data['status_name'],
        );
    }
}
