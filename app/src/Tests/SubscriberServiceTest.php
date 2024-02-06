<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\SubscriberService;
use App\Repositories\SubscriberRepository;
use App\Models\Subscriber;

class SubscriberServiceTest extends TestCase
{
    private $subscriberRepository;
    private $subscriberService;

    protected function setUp(): void
    {
        $this->subscriberRepository = $this->createMock(SubscriberRepository::class);
        $this->subscriberService = new SubscriberService($this->subscriberRepository);
    }

    public function testGetAll()
    {
        $this->subscriberRepository->expects($this->once())
            ->method('getAll')
            ->with(0, 10)
            ->willReturn([]);

        $result = $this->subscriberService->getAll();

        $this->assertEquals([], $result);
    }

    public function testCreateNewSubscriber()
    {
        $subscriber = new Subscriber("test@example.com", "Filipe", "oliveira", "active");

        $this->subscriberRepository->expects($this->once())
            ->method('getByEmail')
            ->with('test@example.com')
            ->willReturn(null);

        $this->subscriberRepository->expects($this->once())
            ->method('create')
            ->with($subscriber);

        $result = $this->subscriberService->create($subscriber);

        $this->assertTrue($result);
    }

    public function testCreateExistingSubscriber()
    {
        $subscriber = new Subscriber("test@example.com", "Filipe", "oliveira", "active");

        $this->subscriberRepository->expects($this->once())
            ->method('getByEmail')
            ->with('test@example.com')
            ->willReturn($subscriber);

        $this->subscriberRepository->expects($this->never())
            ->method('create');

        $result = $this->subscriberService->create($subscriber);

        $this->assertFalse($result);
    }

    public function testGetByEmail()
    {
        $subscriber = new Subscriber("test@example.com", "Filipe", "oliveira", "active");

        $this->subscriberRepository->expects($this->once())
            ->method('getByEmail')
            ->with('test@example.com')
            ->willReturn($subscriber);

        $result = $this->subscriberService->getByEmail('test@example.com');

        $this->assertEquals($subscriber, $result);
    }
}
