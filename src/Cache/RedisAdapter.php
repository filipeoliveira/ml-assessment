<?php 
namespace App\Cache;

class RedisAdapter implements CacheInterface {
    private $redis;

    public function __construct($redis) {
        $this->redis = $redis;
    }

    public function get($key) {
        // TODO - Implement get method using Redis
    }

    public function set($key, $value, $ttl = null) {
        // TODO - Implement set method using Redis
    }

    public function delete($key) {
        // TODO - Implement delete method using Redis
    }

}
