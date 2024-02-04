<?php

namespace Tests\Controllers;

use App\Controllers\SubscriberController;
use App\Models\Subscriber;
use App\Services\SubscriberService;
use App\Utilities\Errors\ErrorCode;
use Pimple\Container;
use PHPUnit\Framework\TestCase;

class SubscriberControllerTest extends TestCase
{
    private $subscriberServiceMock;
    private $containerMock;
    private $subscriberController;

    protected function setUp(): void
    {
        $this->subscriberServiceMock = $this->createMock(SubscriberService::class);
        $this->containerMock = $this->createMock(Container::class);

        $this->containerMock
            ->method('offsetGet')
            ->with('subscriberService')
            ->willReturn($this->subscriberServiceMock);

        $this->subscriberController = new SubscriberController($this->containerMock);
    }

    public function testGetAll()
    {
        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getAll')
            ->willReturn([]);

        $response = $this->subscriberController->getAll();

        $this->assertIsArray($response);
        $this->assertEmpty($response);
    }

    public function testGetAllWithSubscribers()
    {
        $subscribers = [
            new Subscriber('test1@example.com', 'Test1', 'User1', 'Active'),
            new Subscriber('test2@example.com', 'Test2', 'User2', 'Pending'),
        ];

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($subscribers);

        $response = $this->subscriberController->getAll();

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }

    public function testGetAllWithPagination()
    {
        $subscribers = [
            new Subscriber('test1@example.com', 'Test1', 'User1', 'Active'),
            new Subscriber('test2@example.com', 'Test2', 'User2', 'Active'),
        ];

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getAll')
            ->with(1, 1)
            ->willReturn([$subscribers[0]]);

        $response = $this->subscriberController->getAll(1, 1);

        $this->assertIsArray($response);
        $this->assertCount(1, $response);
        $this->assertEquals($subscribers[1], $response);
    }

    public function testGetByEmail()
    {
        $email = 'test@example.com';

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getByEmail')
            ->with($email)
            ->willReturn(new Subscriber($email, 'Test', 'User', 'Active'));

        $response = $this->subscriberController->getByEmail($email);

        $this->assertInstanceOf(Subscriber::class, $response);
        $this->assertContains($email, $response);

    }

    public function testGetByEmailNotFound()
    {
        $email = 'test@example.com';
    
        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getByEmail')
            ->with($email)
            ->willReturn(null);
    
        $response = $this->subscriberController->getByEmail($email);
    
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(ErrorCode::SUBSCRIBER_NOT_FOUND, $response->getContent());
    }

    public function testCreateNewSubscriber()
    {
        $data = [
            'email' => 'test@example.com',
            'name' => 'Test',
            'last_name' => 'User',
            'status' => 'Active'
        ];

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Subscriber::class))
            ->willReturn(true);

        $response = $this->subscriberController->create($data);
        $this->assertInstanceOf(Subscriber::class, $response);
    }

    public function testCreateExistingSubscriber()
    {
        $data = [
            'email' => 'test@example.com',
            'name' => 'Test',
            'last_name' => 'User',
            'status' => 'Active'
        ];

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Subscriber::class))
            ->willReturn(false);

        $response = $this->subscriberController->create($data);

        $this->assertNull($response);
    }
}
