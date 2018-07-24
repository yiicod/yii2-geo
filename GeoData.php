<?php

namespace yiicod\geo;


use yiicod\geo\base\GeoDataInterface;

/**
 * Class GeoData
 * Class to make geo-data structure
 *
 * @package yiicod\geo
 *
 * @author Dmitry Turchanin
 */
class GeoData implements GeoDataInterface
{
    /**
     * Data to keep.
     *
     * @var array
     */
    private $data = [];

    /**
     * GeoDataInterface constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    /**
     * Gets country code.
     *
     * @return null|string
     */
    public function getCountryCode(): ?string
    {
        $result = $this->data['countryCode'] ?? null;
        return $result;
    }

    /**
     * Gets country name
     *
     * @return null|string
     */
    public function getCountryName(): ?string
    {
        $result = $this->data['countryName'] ?? null;
        return $result;
    }

    /**
     * Gets region
     *
     * @return null|string
     */
    public function getRegion(): ?string
    {
        $result = $this->data['region'] ?? null;
        return $result;
    }

    /**
     * Gets region name
     *
     * @return null|string
     */
    public function getRegionName(): ?string
    {
        $result = $this->data['regionName'] ?? null;
        return $result;
    }

    /**
     * Gets region code
     *
     * @return null|string
     */
    public function getRegionCode(): ?string
    {
        $result = $this->data['regionCode'] ?? null;
        return $result;
    }

    /**
     * Gets city
     *
     * @return null|string
     */
    public function getCity(): ?string
    {
        $result = $this->data['city'] ?? null;
        return $result;
    }

    /**
     * Gets latitude
     *
     * @return null|string
     */
    public function getLatitude(): ?string
    {
        $result = $this->data['latitude'] ?? null;
        return $result;
    }

    /**
     * Gets longitude
     *
     * @return null|string
     */
    public function getLongitude(): ?string
    {
        $result = $this->data['longitude'] ?? null;
        return $result;
    }

    /**
     * Gets IP
     *
     * @return null|string
     */
    public function getIp(): string
    {
        $result = $this->data['ip'] ?? null;
        return $result;
    }

    /**
     * Gets all data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Sets all data
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}