<?php

namespace yiicod\geo\adapters\geoPlugin;

use yiicod\geo\base\GeoAdapterInterface;
use yiicod\geo\base\GeoDataInterface;
use yiicod\geo\exceptions\EmptyLocationDataException;
use yiicod\geo\GeoData;

/**
 * Class GeoPluginAdapter
 * Geo getter based on the GeoPlugin source (http://www.geoplugin.net/)
 *
 * @package yiicod\geo\adapters\geoPlugin
 *
 * @author Dmitry Turchanin
 */
class GeoPluginAdapter implements GeoAdapterInterface
{
    /**
     * Loads location data from source for $ip
     *
     * @param $ip
     *
     * @return bool|string
     */
    public function loadLocationData($ip)
    {
        $xml = file_get_contents('http://www.geoplugin.net/xml.gp?ip=' . $ip);

        return $xml;
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
        $xml = $this->loadLocationData($ip);
        $xml = simplexml_load_string($xml);

        if (false === $xml) {
            throw new EmptyLocationDataException("Location data is empty");
        }

        $data = [
            'ip' => $ip,
            'countryCode' => (string)$xml->geoplugin_countryCode,
            'countryName' => (string)$xml->geoplugin_countryName,
            'regionName' => (string)$xml->geoplugin_region,
            'regionCode' => (string)$xml->geoplugin_regionCode,
            'city' => (string)$xml->geoplugin_city,
            'latitude' => (float)$xml->geoplugin_latitude,
            'longitude' => (float)$xml->geoplugin_longitude,
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
        return 'geo_plugin';
    }
}
