<?php

namespace yiicod\geo\storages;

use Yii;
use yii\caching\CacheInterface;

/**
 * Class CacheStorage
 * Storage that uses Yii cache functionality
 *
 * @package yiicod\geo\storages
 *
 * @author Dmitry Turchanin
 */
class CacheStorage implements StorageInterface
{
    /**
     * Cache component name
     *
     * @var string
     */
    public $component = 'cache';

    /**
     * Gets data for $key from storage
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $key = self::buildKey($key);

        $value = $this->getStorage()->get($key);
        return $value;
    }

    /**
     * Stores data for $key into storage
     *
     * @param $key
     * @param $value
     * @param int $duration
     */
    public function set($key, $value, $duration = 0): void
    {
        $key = self::buildKey($key);

        $this->getStorage()->set($key, $value, $duration);
    }

    /**
     * Method combines both [[set()]] and [[get()]] methods to retrieve value identified by a $key,
     * or to store the result of $callable execution if there is no cache available for the $ip.
     *
     * @param $key
     * @param $callable
     * @param int $duration
     *
     * @return mixed
     */
    public function getOrSet($key, $callable, $duration = 0)
    {
        $key = self::buildKey($key);

        $value = $this->getStorage()->getOrSet($key, $callable, $duration);

        return $value;
    }

    /**
     * Deletes record from storage for $key
     *
     * @param $key
     *
     * @return mixed
     */
    public function delete($key): void
    {
        $key = self::buildKey($key);

        $this->getStorage()->delete($key);
    }

    /**
     * Builds a normalized storage key from a given $key.
     *
     * @param mixed $key the key to be normalized
     *
     * @return string the generated cache key
     */
    public function buildKey($key): string
    {
        $key = sprintf('geo-getter-data-%s', $key);

        return $key;
    }

    /**
     * Returns storage component
     *
     * @return mixed|CacheInterface
     */
    private function getStorage()
    {
        return Yii::$app->{$this->component};
    }
}