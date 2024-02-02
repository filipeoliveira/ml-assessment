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
    }

    public function delete($key) {
    }

}
