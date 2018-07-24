<?php

namespace yiicod\geo\adapters\geoIp2;

use GeoIp2\Database\Reader;
use Yii;
use yiicod\geo\base\GeoAdapterInterface;
use yiicod\geo\base\GeoDataInterface;
use yiicod\geo\exceptions\EmptyLocationDataException;
use yiicod\geo\GeoData;

/**
 * Class GeoIp2OfflineAdapter
 *
 * @package yiicod\geo\adapters\geoIpOffline
 */
class GeoIp2CityAdapter implements GeoAdapterInterface
{
    /**
     * @var array
     */
    public $databaseConfig = [
        'class' => GeoIp2Database::class,
    ];

    /**
     * GeoIp2 Reader
     *
     * @var Reader
     */
    private $geoIpReader;

    /**
     * Loads location data from source for $ip
     *
     * @param $ip
     *
     * @return \GeoIp2\Model\City
     */
    public function loadLocationData($ip)
    {
        $reader = $this->getGeoIpReader();

        $data = $reader ? $this->getGeoIpReader()->city($ip) : null;

        return $data;
    }

    /**
     * Gets location data from loaded data
     *
     * @param $ip
     *
     * @return GeoDataInterface
     *
     * @throws EmptyLocationDataException
     */
    public function getLocationData($ip): GeoDataInterface
    {
        $locationData = $this->loadLocationData($ip);
        if (empty($locationData)) {
            throw new EmptyLocationDataException("Location data is empty");
        }

        $region = $locationData->subdivisions[0] ?? null;
        $data = [
            'ip' => $ip,
            'countryCode' => $locationData->country->isoCode,
            'countryName' => $locationData->country->names['en'],
            'regionName' => $region->names['en'] ?? null,
            'regionCode' => $region->isoCode ?? null,
            'city' => $locationData->city->names['en'],
            'latitude' => $locationData->location->latitude,
            'longitude' => $locationData->location->longitude,
        ];

        $result = new GeoData($data);
        return $result;
    }

    /**
     * Gets adapter's name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'geo_ip_city_offline';
    }

    /**
     * Gets GeoIP Reader
     *
     * @return Reader
     */
    private function getGeoIpReader(): ?Reader
    {
        if (is_null($this->geoIpReader)) {
            /** @var GeoIpDatabaseInterface $db */
            $db = Yii::createObject($this->databaseConfig);
            if (true === $db->hasDbFile()) {
                $this->geoIpReader = new Reader($db->getFileName());
            }
        }

        return $this->geoIpReader;
    }
}
