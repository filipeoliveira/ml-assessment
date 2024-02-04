<?php

namespace App\Utilities;

use App\Models\Response;

class Http
{
    /**
     * Create a new instance of the Response class.
     *
     * @return Response A new Response object.
     */
    public function response($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        $data = json_encode($data);
        echo $data;
        return $data;
    }

    /**
     * Retrieve and validate the 'page' and 'pageSize' parameters from the query string.
     *
     * If these parameters are not present or are not valid integers, default values are used.
     * Default value for 'page' is 0 and for 'pageSize' is 10.
     *
     * @return array An array containing the 'page' and 'pageSize' values.
     */
    public function getPaginationParameters()
    {
        $defaultPage = 0;
        $defaultPageSize = 10;

        $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage;
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : $defaultPageSize;

        $page = filter_var($page, FILTER_VALIDATE_INT);
        $pageSize = filter_var($pageSize, FILTER_VALIDATE_INT);

        // If page or pageSize are not valid integers, use default values
        $page = $page !== false ? $page : $defaultPage;
        $pageSize = $pageSize !== false ? $pageSize : $defaultPageSize;

        return [$page, $pageSize];
    }

    /**
     * Parses the POST data from the request.
     *
     * This method checks the Content-Type of the request and returns the POST data as an array.
     *
     * @return array The POST data.
     */
    public function parsePostData(string $contentType, $rawData = null)
    {
        if (strpos($contentType, 'application/json') !== false) {
            $rawData = $rawData ?? file_get_contents('php://input');
            $data = json_decode($rawData, true);
        } else {
            $data = $_POST;
        }

        return $data;
    }
}
