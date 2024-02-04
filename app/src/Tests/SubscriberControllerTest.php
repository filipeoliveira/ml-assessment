<?php

namespace Tests;

use App\Models\Subscriber;
use App\Controllers\SubscriberController;
use App\Services\SubscriberService;
use App\Utilities\Http;
use App\Utilities\Errors\ErrorCode;
use PHPUnit\Framework\TestCase;

class SubscriberControllerTest extends TestCase
{
    private $httpMock;
    private $subscriberServiceMock;
    private $subscriberController;

    protected function setUp(): void
    {
        $this->httpMock = $this->createMock(Http::class);
        $this->subscriberServiceMock = $this->createMock(SubscriberService::class);
        $this->subscriberController = new SubscriberController($this->httpMock, $this->subscriberServiceMock);
    }

    public function testGetAllEmpty()
    {
        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getAll')
            ->willReturn([]);


        $this->httpMock->expects($this->once())
            ->method('response')
            ->with([], 200);

        $this->subscriberController->getAll();
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


        $this->httpMock->expects($this->once())
            ->method('response')
            ->with($subscribers, 200);

        $this->subscriberController->getAll();
    }

    public function testGetAllWithPagination()
    {
        // set pagination parameters
        $_GET['page'] = 1;
        $_GET['pageSize'] = 1;

        $subscribers = [
            new Subscriber('test1@example.com', 'Test1', 'User1', 'Active'),
            new Subscriber('test2@example.com', 'Test2', 'User2', 'Active'),
        ];
        $expected = [$subscribers[0]];


        $this->httpMock->expects($this->once())
            ->method('getPaginationParameters')
            ->willReturn([$_GET['page'], $_GET['pageSize']]);

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getAll')
            ->with($_GET['page'], $_GET['pageSize'])
            ->willReturn($expected);

        $this->httpMock->expects($this->once())
            ->method('response')
            ->with($expected, 200);

        $this->subscriberController->getAll();
    }

    public function testGetByEmail()
    {
        $email = 'test@example.com';
        $subscriber = new Subscriber($email, 'Test', 'User', 'Active');

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getByEmail')
            ->with($email)
            ->willReturn($subscriber);

        $this->httpMock->expects($this->once())
            ->method('response')
            ->with($subscriber, 200);

        $this->subscriberController->getByEmail($email);
    }

    public function testGetByEmailNotFound()
    {
        $email = 'test@example.com';

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('getByEmail')
            ->with($email)
            ->willReturn(null);

        $this->httpMock->expects($this->once())
            ->method('response')
            ->with(ErrorCode::SUBSCRIBER_NOT_FOUND, 404);

        $this->subscriberController->getByEmail($email);
    }

    public function testCreateNewSubscriber()
    {
        $_SERVER['CONTENT_TYPE'] = "application/json";
        $data = [
            'email' => 'tes111t@example.com',
            'name' => 'Test',
            'last_name' => 'User',
            'status' => 'Active'
        ];
        $subscriber = new Subscriber($data['email'], $data['name'], $data['last_name'], $data['status']);

        // Mock
        $this->httpMock->expects($this->once())
            ->method('parsePostData')
            ->with($_SERVER['CONTENT_TYPE'], null)
            ->willReturn($data);

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Subscriber::class))
            ->willReturn(true);

        $this->httpMock->expects($this->once())
            ->method('response')
            ->with($subscriber, 201);

        $this->subscriberController->create();
    }

    public function testCreateExistingSubscriber()
    {
        $_SERVER['CONTENT_TYPE'] = "application/json";
        $data = [
            'email' => 'test2@example.com',
            'name' => 'Test',
            'last_name' => 'User',
            'status' => 'Active'
        ];

        // Mock
        $this->httpMock->expects($this->once())
            ->method('parsePostData')
            ->with($_SERVER['CONTENT_TYPE'], null)
            ->willReturn($data);

        $this->subscriberServiceMock
            ->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Subscriber::class))
            ->willReturn(false);

        $this->httpMock->expects($this->once())
            ->method('response')
            ->with(ErrorCode::SUBSCRIBER_ALREADY_EXISTS, 200);

        $this->subscriberController->create();
    }
}
