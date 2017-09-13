<?php

namespace yiicod\geo\base;

interface LocatorInterface
{
    /**
     * Gets country code by IP
     *
     * @param string|null
     *
     * @return string
     */
    public function getCountryCode($ip);

    /**
     * Gets country code by IP
     *
     * @param string|null
     *
     * @return string
     */
    public function getCountryName($ip);
}
