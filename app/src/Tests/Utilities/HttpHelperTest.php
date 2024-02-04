<?php

use PHPUnit\Framework\TestCase;
use App\Models\Response;

class HttpHelperTest extends TestCase
{
    public function testResponse()
    {
        $response = response();
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testGetPaginationParameters()
    {
        $_GET['page'] = '2';
        $_GET['pageSize'] = '20';

        [$page, $pageSize] = getPaginationParameters();

        $this->assertEquals(2, $page);
        $this->assertEquals(20, $pageSize);
    }

    public function testGetPaginationParametersWithInvalidValues()
    {
        $_GET['page'] = 'invalid';
        $_GET['pageSize'] = 'invalid';

        [$page, $pageSize] = getPaginationParameters();

        $this->assertEquals(0, $page);
        $this->assertEquals(10, $pageSize);
    }

    public function testParsePostDataJson()
    {
        $contentType = 'application/json';
        $json = json_encode(['key' => 'value']);
    
        $data = parsePostData($contentType, $json);
    
        $this->assertEquals(['key' => 'value'], $data);
    }

    public function testParsePostDataForm()
    {
        $contentType = 'application/x-www-form-urlencoded';
        $_POST = ['key' => 'value'];

        $data = parsePostData($contentType);

        $this->assertEquals(['key' => 'value'], $data);
    }
}
