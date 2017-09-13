<?php

namespace yiicod\geo;

use Exception;
use Yii;
use yii\base\Component;
use yii\caching\Cache;
use yiicod\geo\base\LocatorAbstract;
use yiicod\geo\base\LocatorInterface;

/**
 * Class GeoManager
 *
 * @author Dmitry Turchanin
 *
 * @package yiicod\geo\components
 */
class GeoFinder extends Component implements LocatorInterface
{
    /**
     * @var array
     */
    public $gettersList = [
        [
            'class' => \yiicod\geo\locators\geoIpOffline\GeoIpOfflineLocator::class,
        ],
        [
            'class' => \yiicod\geo\locators\geoPlugin\GeoPluginLocator::class,
        ],
        [
//            'class' => \yiicod\geo\locators\freeGeoIp\FreeGeoIpLocator::class
        ],
    ];

    /**
     * Cache expire value
     *
     * @var int
     */
    public $duration = 604800;

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
     * Gets country code by IP
     *
     * @param string|null
     *
     * @return string
     */
    public function getCountryCode($ip)
    {
        return $this->getPreparedCountryData($ip)['countryCode'] ?? null;
    }

    /**
     * Gets country code by IP
     *
     * @param string|null
     *
     * @return string
     */
    public function getCountryName($ip)
    {
        return $this->getPreparedCountryData($ip)['countryName'] ?? null;
    }

    /**
     * Gets prepared country data by IP (country code, country name)
     *
     * @param null|string|mixed $ip
     *
     * @return null|array
     */
    public function getPreparedCountryData($ip)
    {
        if (true === isset(self::$result[$ip])) {
            return self::$result[$ip];
        }

        /** @var Cache $cache */
        $cache = Yii::$app->{$this->storage};

        self::$result[$ip] = $cache->getOrSet(sprintf('geo-finder-%s', $ip), function () use ($ip) {
            foreach ($this->gettersList as $key => $config) {
                try {
                    $getter = Yii::createObject(array_merge(['storage' => $this->storage], $config));
                    if (!($getter instanceof LocatorAbstract)) {
                        unset($key);
                        continue;
                    }

                    return $getter->getPreparedCountryData($ip);
                } catch (Exception $e) {
                    unset($key);
                    continue;
                }
            }
        }, $this->duration);

        return self::$result[$ip] ?? null;
    }
}
