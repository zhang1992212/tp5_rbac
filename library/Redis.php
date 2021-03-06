<?php

namespace geek1992\tp5_rbac\library;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Redis
{
    private static $instance = null;

    protected static $config = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'auth' => 'Zjl1992212!'
    ];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getRedis()
    {
        if (class_exists('redis') && null === static::$instance) {
            static::$instance = static::connect();
        }

        return static::$instance;
    }

    /**
     * 获取REDIS 的key
     * @param array|null $condition
     * @return string
     */
    public static function getKey(?array $condition = null): string
    {
        return md5('redis'.md5(http_build_query($condition)));
    }

    private static function connect()
    {
        $redis = null;
        try{
            $redis = new \Redis();
            $host = static::$config['host'];
            $port = static::$config['port'];
            $redis->connect($host, $port);
            $redis->auth(static::$config['auth']);
        } catch (\Exception $e) {

        }
        
        return $redis;
    }
}
