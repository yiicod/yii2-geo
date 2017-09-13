<?php

namespace yiicod\geo\locators\geoPlugin;

use yiicod\geo\base\LocatorAbstract;

/**
 * Class GeoPluginLocator
 * Geo getter based on the GeoPlugin source (http://www.geoplugin.net/)
 *
 * @package yiicod\geo\geo
 *
 * @author Dmitry Turchanin
 */
class GeoPluginLocator extends LocatorAbstract
{
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
            $country = (string)$xml->geoplugin_countryCode;
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
            $countryName = (string)$xml->geoplugin_countryName;
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
        $xml = file_get_contents('http://www.geoplugin.net/xml.gp?ip=' . $ip);

        return $xml;
    }

    /**
     * Get locator name
     *
     * @return string
     */
    protected function getName()
    {
        return 'geo_plugin';
    }
}
