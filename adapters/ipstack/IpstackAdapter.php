<?php

namespace yiicod\geo\adapters\ipstack;

use yiicod\geo\base\GeoAdapterInterface;
use yiicod\geo\base\GeoDataInterface;
use yiicod\geo\exceptions\EmptyLocationDataException;
use yiicod\geo\GeoData;

/**
 * Class IpstackAdapter
 * Geo getter based on the ipstack source (http://ipstack.com/)
 *
 * @package yiicod\geo\adapters\ipstack
 *
 * @author Dmitry Turchanin
 */
class IpstackAdapter implements GeoAdapterInterface
{

    /**
     * ipstack API-key
     *
     * @var string
     */
    public $apiKey = '';

    /**
     * Loads location data from source for $ip
     *
     * @param $ip
     *
     * @return bool|string
     */
    public function loadLocationData($ip)
    {
        $data = file_get_contents(sprintf('http://api.ipstack.com/%s?access_key=%s', $ip, $this->apiKey));

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
        $json = $this->loadLocationData($ip);

        $decoded = json_decode($json, true);

        if (empty($decoded)) {
            throw new EmptyLocationDataException("Location data is empty");
        }

        $data = [
            'ip' => $ip,
            'countryCode' => $decoded['country_code'] ?? null,
            'countryName' => $decoded['country_name'] ?? null,
            'regionName' => $decoded['region_name'] ?? null,
            'regionCode' => $decoded['region_code'] ?? null,
            'city' => $decoded['city'] ?? null,
            'latitude' => $decoded['latitude'] ?? null,
            'longitude' => $decoded['longitude'] ?? null,
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
        return 'ipstack_';
    }
}
