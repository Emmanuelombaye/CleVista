<?php
/**
 * CleVista Group Limited - Redis Connection & Caching Helper
 * Gracefully wraps Predis and falls back if the Redis server goes offline.
 */

require_once __DIR__ . '/../vendor/autoload.php';

$redis = null;
$redis_error = null;

try {
    // Initialize Redis client connecting to localhost
    $redis = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => '127.0.0.1',
        'port'   => 6379,
        'timeout' => 1.0, // fast timeout for seamless fallback
    ]);
    // Test connection with a quick ping
    $redis->ping();
} catch (\Exception $e) {
    $redis = null;
    $redis_error = $e->getMessage();
}

/**
 * Get cached item from Redis (returns null if cache miss or Redis offline)
 */
function redis_get($key) {
    global $redis;
    if ($redis) {
        try {
            return $redis->get($key);
        } catch (\Exception $e) {
            return null;
        }
    }
    return null;
}

/**
 * Save item in Redis with an expiration time in seconds (default 5 minutes)
 */
function redis_set($key, $value, $expire = 300) {
    global $redis;
    if ($redis) {
        try {
            $redis->setex($key, $expire, $value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    return false;
}
