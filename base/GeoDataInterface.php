<?php

namespace yiicod\geo\base;

/**
 * Interface GeoDataInterface
 *
 * @package yiicod\geo\base
 *
 * @author Dmitry Turchanin
 */
interface GeoDataInterface
{
    /**
     * GeoDataInterface constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = []);

    /**
     * Gets country code
     *
     * @return null|string
     */
    public function getCountryCode(): ?string;

    /**
     * Gets country name
     *
     * @return null|string
     */
    public function getCountryName(): ?string;

    /**
     * Gets region
     *
     * @return null|string
     */
    public function getRegion(): ?string;

    /**
     * Gets region name
     *
     * @return null|string
     */
    public function getRegionName(): ?string;

    /**
     * Gets region code
     *
     * @return null|string
     */
    public function getRegionCode(): ?string;

    /**
     * Gets city
     *
     * @return null|string
     */
    public function getCity(): ?string;

    /**
     * Gets latitude
     *
     * @return null|string
     */
    public function getLatitude(): ?string;

    /**
     * Gets longitude
     *
     * @return null|string
     */
    public function getLongitude(): ?string;

    /**
     * Gets IP
     *
     * @return null|string
     */
    public function getIp(): string;

    /**
     * Gets all data
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Sets all data
     *
     * @param array $data
     */
    public function setData(array $data): void;
}
