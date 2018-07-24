<?php

namespace yiicod\geo\base;

/**
 * Interface GeoFinderInterface
 *
 * @package yiicod\geo\base
 *
 * @author Dmitry Turchanin
 */
interface GeoFinderInterface
{
    /**
     * Gets country code by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getCountryCode(string $ip): ?string;

    /**
     * Gets country name by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getCountryName(string $ip): ?string;

    /**
     * Gets region by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getRegion(string $ip): ?string;

    /**
     * Gets region name by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getRegionName(string $ip): ?string;

    /**
     * Gets region code by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getRegionCode(string $ip): ?string;

    /**
     * Gets city by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getCity(string $ip): ?string;

    /**
     * Gets latitude by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getLatitude(string $ip): ?string;

    /**
     * Gets longitude by IP
     *
     * @param string $ip
     *
     * @return null|string
     */
    public function getLongitude(string $ip): ?string;
}
