<?php

namespace yiicod\geo\base;

use Yii;
use yii\caching\Cache;

/**
 * Class BaseGeoGetter
 * Base class for geo getters
 *
 * @package yiicod\geo\geo\base
 *
 * @author Dmitry Turchanin
 */
abstract class LocatorAbstract
{
    /**
     * Cache expire value
     *
     * @var int
     */
    public $duration = 0;

    /**
     * Cache provider
     *
     * @var Cache
     */
    public $storage = 'cache';

    /**
     * Prepared country data found in the one request
     *
     * @var array
     */
    private static $result = [];

    /**
     * Gets prepared country data by IP (country code, country name)
     *
     * @param null|string $ip
     *
     * @return null|array
     */
    public function getPreparedCountryData($ip)
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();
        /** @var Cache $cache */
        $cache = Yii::$app->{$this->storage};

        if (null === (self::$result[$ip] ?? null)) {
            self::$result[$ip] = $cache->getOrSet(sprintf('%s-%s', $this->getName(), $ip), function () use ($ip) {
                $locationData = $this->getLocationData($ip);

                $result = [
                    'countryCode' => $this->getCountryCodeFromLocationData($locationData),
                    'countryName' => $this->getCountryNameFromLocationData($locationData),
                    'ip' => $ip,
                ];

                foreach ($result as $dataItem) {
                    if (empty($dataItem)) {
                        $result = null;
                        break;
                    }
                }

                return $result;
            }, $this->duration);
        }

        return self::$result[$ip];
    }

    /**
     * Gets country code from the location data
     *
     * @param string $locationData
     *
     * @return bool|string
     */
    abstract protected function getCountryCodeFromLocationData($locationData);

    /**
     * Gets country name from the location data
     *
     * @param string $locationData
     *
     * @return bool|string
     */
    abstract protected function getCountryNameFromLocationData($locationData);

    /**
     * Get locator name
     *
     * @return string
     */
    abstract protected function getName();

    /**
     * Receives location data from the source
     *
     * @param $ip
     *
     * @return string
     */
    abstract protected function getLocationData($ip);
}
