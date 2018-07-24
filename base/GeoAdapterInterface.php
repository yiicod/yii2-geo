<?php

namespace yiicod\geo\base;


/**
 * Interface GeoAdapterInterface
 *
 * @package yiicod\geo\base
 *
 * @author Dmitry Turchanin
 */
interface GeoAdapterInterface
{
    /**
     * Loads location data from source for $ip
     *
     * @param $ip
     *
     * @return mixed
     */
    public function loadLocationData($ip);

    /**
     * Gets location data from loaded data
     *
     * @param $ip
     *
     * @return GeoDataInterface
     */
    public function getLocationData($ip): GeoDataInterface;

    /**
     * Gets adapter's name
     *
     * @return string
     */
    public function getName(): string;
}