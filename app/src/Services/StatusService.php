<?php

namespace App\Service;

use App\Repositories\StatusRepository;

class StatusService
{
    private $statusRepository;

    public function __construct()
    {
        $this->statusRepository = new StatusRepository();
    }

    /**
     * Retrieves a status by its ID.
     *
     * @param int $id The ID of the status.
     * @return array|null The status, or null if no status with the given ID exists.
     */
    public function getById($id)
    {
        return $this->statusRepository->getById($id);
    }
}
