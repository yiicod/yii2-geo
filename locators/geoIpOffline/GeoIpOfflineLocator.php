<?php

namespace yiicod\geo\locators\geoIpOffline;

use Yii;
use yiicod\geo\base\LocatorAbstract;

/**
 * Class GeoIpOfflineLocator
 *
 * @package yiicod\geo\locators\geoIpOffline
 */
class GeoIpOfflineLocator extends LocatorAbstract
{
    /**
     * @var array
     */
    public $geoIpConfig = [
        'class' => GeoIpWrapper::class,
    ];

    /**
     * @var GeoIpDatabase
     */
    private $geoIpObject;

    /**
     * Gets country code from the location data
     *
     * @param $locationData
     *
     * @return bool|string
     */
    protected function getCountryCodeFromLocationData($locationData)
    {
        $country = false;
        if (is_array($locationData) && !empty($locationData['countryCode'])) {
            $country = $locationData['countryCode'];
        }

        return $country;
    }

    /**
     * Gets country name from the location data
     *
     * @param $locationData
     *
     * @return bool|string
     */
    protected function getCountryNameFromLocationData($locationData)
    {
        $countryName = false;
        if (is_array($locationData) && !empty($locationData['countryName'])) {
            $countryName = $locationData['countryName'];
        }

        return $countryName;
    }

    /**
     * Receives location data from the source
     *
     * @param $ip
     *
     * @return bool|string
     */
    protected function getLocationData($ip)
    {
        $data = $this->getGeoIpObject()->getFullDataByIp($ip);

        return $data;
    }

    /**
     * Get locator name
     *
     * @return string
     */
    protected function getName()
    {
        return 'geo_ip_offline';
    }

    /**
     * @return object|GeoIpDatabase|GeoIpWrapper
     */
    private function getGeoIpObject()
    {
        if (empty($this->geoIpObject)) {
            $this->geoIpObject = Yii::createObject($this->geoIpConfig);
        }

        return $this->geoIpObject;
    }
}
