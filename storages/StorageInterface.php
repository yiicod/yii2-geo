<?php

namespace yiicod\geo\storages;

/**
 * Interface StorageInterface is the base interface for storage.
 *
 * @package yiicod\geo\storages
 *
 * @author Dmitry Turchanin
 */
interface StorageInterface
{
    /**
     * Gets data for $key from storage
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Stores data for $key into storage
     *
     * @param $key
     * @param $value
     * @param int $duration
     */
    public function set($key, $value, $duration = 0): void;

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
    public function getOrSet($key, $callable, $duration = 0);

    /**
     * Deletes record from storage for $key
     *
     * @param $key
     *
     * @return mixed
     */
    public function delete($key): void;

    /**
     * Builds a normalized storage key from a given IP.
     *
     * @param mixed $key the key to be normalized
     *
     * @return string the generated cache key
     */
    public function buildKey($key): string;
}