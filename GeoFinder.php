<?php

namespace yiicod\geo;

use Exception;
use Yii;
use yii\base\Component;
use yiicod\geo\base\GeoAdapterInterface;
use yiicod\geo\base\GeoDataInterface;
use yiicod\geo\base\GeoFinderInterface;
use yiicod\geo\storages\StorageInterface;

/**
 * Class GeoManager
 *
 * @package yiicod\geo\components
 *
 * @author Dmitry Turchanin
 * @author Alexey Orlov
 */
class GeoFinder extends Component implements GeoFinderInterface
{
    /**
     * @var array
     */
    public $gettersList = [
        [
            'class' => \yiicod\geo\adapters\geoIp2\GeoIp2CityAdapter::class,
        ],
        [
            'class' => \yiicod\geo\adapters\geoPlugin\GeoPluginAdapter::class,
        ],
        [
            'class' => \yiicod\geo\adapters\ipstack\IpstackAdapter::class,
        ],
        [
//            'class' => \yiicod\geo\adapters\freeGeoIp\FreeGeoIpLocator::class
        ],
    ];

    /**
     * Cache expire value
     *
     * @var int
     */
    public $duration = 604800;

    /**
     * Storage instance
     *
     * @var StorageInterface
     */
    private $storage;

    /**
     * Prepared country data found in the one request
     *
     * @var array
     */
    private static $result = [];

    /**
     * GeoFinder constructor.
     *
     * @param StorageInterface $storage
     * @param array $config
     */
    public function __construct(StorageInterface $storage, $config = [])
    {
        parent::__construct($config);

        $this->storage = $storage;
    }

    /**
     * Gets country code by IP
     *
     * @param string|null
     *
     * @return string
     */
    public function getCountryCode(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getCountryCode();
    }

    /**
     * Gets country code by IP
     *
     * @param string|null
     *
     * @return string
     */
    public function getCountryName(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getCountryName();
    }

    /**
     * Gets region by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getRegion(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getRegion();
    }

    /**
     * Gets region name by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getRegionName(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getRegionName();
    }

    /**
     * Gets region code by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getRegionCode(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getRegionCode();
    }

    /**
     * Gets city by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getCity(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getCity();
    }

    /**
     * Gets latitude by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getLatitude(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getLatitude();
    }

    /**
     * Gets longitude by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getLongitude(string $ip): ?string
    {
        return $this->getPreparedCountryData($ip)->getLongitude();
    }

    /**
     * Gets prepared country data by IP (country code, country name)
     *
     * @param null|string|mixed $ip
     *
     * @return GeoDataInterface
     */
    public function getPreparedCountryData($ip): GeoDataInterface
    {
        if (true === isset(self::$result[$ip])) {
            return self::$result[$ip];
        }

        self::$result[$ip] = $this->storage->getOrSet($ip, function () use ($ip) {
            foreach ($this->gettersList as $key => $config) {
                try {
                    $adapter = Yii::createObject($config);

                    if (!($adapter instanceof GeoAdapterInterface)) {
                        unset($key);
                        continue;
                    }

                    return $adapter->getLocationData($ip);
                } catch (Exception $e) {
                    unset($key);
                    continue;
                }
            }

            return new GeoData(['ip' => $ip]);
        }, $this->duration);

        return self::$result[$ip];
    }
}
