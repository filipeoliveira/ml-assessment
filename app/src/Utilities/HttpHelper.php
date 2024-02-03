<?php

use App\Response;

/**
 * Create a new instance of the Response class.
 *
 * @return Response A new Response object.
 */
function response()
{
    return new Response();
}

/**
 * Retrieve and validate the 'page' and 'pageSize' parameters from the query string.
 *
 * If these parameters are not present or are not valid integers, default values are used.
 * Default value for 'page' is 0 and for 'pageSize' is 25.
 *
 * @return array An array containing the 'page' and 'pageSize' values.
 */
function getPaginationParameters()
{
    $defaultPage = 0;
    $defaultPageSize = 25;

    $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage;
    $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : $defaultPageSize;

    $page = filter_var($page, FILTER_VALIDATE_INT);
    $pageSize = filter_var($pageSize, FILTER_VALIDATE_INT);

    // If page or pageSize are not valid integers, use default values
    $page = $page !== false ? $page : $defaultPage;
    $pageSize = $pageSize !== false ? $pageSize : $defaultPageSize;

    return [$page, $pageSize];
}
