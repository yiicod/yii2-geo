<?php

namespace yiicod\geo\locators\freeGeoIp;

use yiicod\geo\base\LocatorAbstract;

/**
 * Class FreeGeoIpLocator
 * Geo getter based on the FreeGeoIp source (https://freegeoip.net)
 *
 * @package yiicod\geo\geo
 *
 * @author Dmitry Turchanin
 */
class FreeGeoIpLocator extends LocatorAbstract
{
    public static $locationData;

    /**
     * Gets country code from the location data
     *
     * @param $locationData
     *
     * @return bool|string
     */
    protected function getCountryCodeFromLocationData($locationData)
    {
        $xml = simplexml_load_string($locationData);

        $country = false;
        if (false !== $xml) {
            $country = (string)$xml->CountryCode;
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
        $xml = simplexml_load_string($locationData);

        $countryName = false;
        if (false !== $xml) {
            $countryName = (string)$xml->CountryName;
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
        $xml = file_get_contents('https://freegeoip.net/xml/' . $ip);

        return $xml;
    }

    /**
     * Get locator name
     *
     * @return string
     */
    protected function getName()
    {
        return 'free_geo_ip';
    }
}
