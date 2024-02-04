<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Response;
use App\Utilities\Http;

class HttpTest extends TestCase
{
    private $http;

    protected function setUp(): void
    {
        $this->http = new Http();
    }

    public function testResponse()
    {
        $http = new Http();
        $data = ['foo' => 'bar'];

        ob_start();
        $result = $http->response($data, 200);

        // Get the output from the response method
        $output = ob_get_clean();

        $this->assertEquals(json_encode($data), $result);
        $this->assertEquals(json_encode($data), $output);
    }

    public function testGetPaginationParameters()
    {
        $_GET['page'] = '2';
        $_GET['pageSize'] = '20';

        [$page, $pageSize] = $this->http->getPaginationParameters();

        $this->assertEquals(2, $page);
        $this->assertEquals(20, $pageSize);
    }

    public function testGetPaginationParametersWithInvalidValues()
    {
        $_GET['page'] = 'invalid';
        $_GET['pageSize'] = 'invalid';

        [$page, $pageSize] = $this->http->getPaginationParameters();

        $this->assertEquals(0, $page);
        $this->assertEquals(10, $pageSize);
    }

    public function testParsePostDataJson()
    {
        $contentType = 'application/json';
        $json = json_encode(['key' => 'value']);

        $data = $this->http->parsePostData($contentType, $json);

        $this->assertEquals(['key' => 'value'], $data);
    }

    public function testParsePostDataForm()
    {
        $contentType = 'application/x-www-form-urlencoded';
        $_POST = ['key' => 'value'];

        $data = $this->http->parsePostData($contentType);

        $this->assertEquals(['key' => 'value'], $data);
    }
}
