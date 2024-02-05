<?php

namespace Tests\Repositories;

use App\Repositories\SubscriberRepository;
use App\Connection\DatabaseConnection;
use App\Connection\CacheConnection;
use App\Models\Subscriber;
use Mockery;
use PHPUnit\Framework\TestCase;

class SubscriberRepositoryTest extends TestCase
{
    protected $dbMock;
    protected $cacheMock;
    protected $subscriberRepository;

    public function setUp(): void
    {
        $this->dbMock = Mockery::mock(DatabaseConnection::class);
        $this->cacheMock = Mockery::mock(CacheConnection::class);

        // Set expectation for the getConnection method
        $this->dbMock->shouldReceive('getConnection')->andReturnSelf();
        $this->cacheMock->shouldReceive('getConnection')->andReturnSelf();
        $this->subscriberRepository = new SubscriberRepository($this->dbMock, $this->cacheMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetAll()
    {
        // Mock the database query and fetch methods
        $this->dbMock->shouldReceive('query', 'prepare', 'bindParam', 'execute')
            ->andReturnSelf();

        $this->dbMock->shouldReceive('fetchColumn')->andReturn(10);
        $this->dbMock->shouldReceive('fetchAll')->andReturn([
            ['email' => 'test1@example.com', 'name' => 'Test1', 'last_name' => 'User1', 'status' => 'active'],
            ['email' => 'test2@example.com', 'name' => 'Test2', 'last_name' => 'User2', 'status' => 'inactive'],
        ]);

        $result = $this->subscriberRepository->getAll(1, 2);

        $this->assertCount(2, $result['data']);
        $this->assertEquals(1, $result['metadata']['page']);
        $this->assertEquals(2, $result['metadata']['pageSize']);
        $this->assertEquals(10, $result['metadata']['totalSubscribers']);
        $this->assertEquals(5, $result['metadata']['totalPages']);
    }

    public function testGetByEmailCacheMiss()
    {
        // Mock the cache get method
        $this->cacheMock->shouldReceive('get')->andReturn(null);
        $this->cacheMock->shouldReceive('set')->andReturnSelf();

        // Mock the database prepare, bindParam, execute, and fetch methods
        $this->dbMock->shouldReceive('prepare', 'bindParam', 'execute')->andReturnSelf();
        $this->dbMock->shouldReceive('fetch')->andReturn([
            'email' => 'test@example.com',
            'name' => 'Test',
            'last_name' => 'User',
            'status' => 'active'
        ]);


        $result = $this->subscriberRepository->getByEmail('test@example.com');

        $this->assertInstanceOf(Subscriber::class, $result);
        $this->assertEquals('test@example.com', $result->getEmail());
        $this->assertEquals('Test', $result->getName());
        $this->assertEquals('User', $result->getLastName());
        $this->assertEquals('active', $result->getStatus());
    }

    public function testGetByEmailCacheHit()
    {
        $email = 'test@example.com';
        $subscriber = new Subscriber($email, 'Test', 'User', 'active');
    
        // Mock the cache get method return a serialized Subscriber object
        $this->cacheMock->shouldReceive('get')->andReturn(json_encode($subscriber));
    
        // Act
        $result = $this->subscriberRepository->getByEmail($email);
    
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($email, $result->email);
        $this->assertEquals('Test', $result->name);
        $this->assertEquals('User', $result->lastName);
        $this->assertEquals('active', $result->status);
    }


    public function testCreate()
    {
        $subscriber = new Subscriber('test@example.com', 'Test', 'User', 'active');

        // Mock the getByEmail method to return null  -- indicating the subscriber does not exist yet
        $this->dbMock->shouldReceive('getByEmail')->andReturn(null);

        // Mock the db operations
        $this->dbMock->shouldReceive('beginTransaction', 'prepare', 'fetch', 'bindParam', 'execute', 'commit')
            ->andReturnSelf();


        // act
        $this->subscriberRepository->create($subscriber);
        $this->assertTrue(true);
    }
}
