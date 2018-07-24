<?php

namespace yiicod\geo\adapters\geoIp2;


/**
 * Interface GeoIpDatabaseInterface
 *
 * @package yiicod\geo\adapters\geoIp2
 *
 * @author Dmitry Turchanin
 */
interface GeoIpDatabaseInterface
{
    /**
     * Checks if DB-file exists and it is actual. Ff not then it starts file update
     *
     * @return bool
     */
    public function hasDbFile(): bool;

    /**
     * Downloads and unpacks fresh IP database file in the background process
     *
     * @return mixed
     */
    public function updateDbFile();

    /**
     * Gets local database's file name
     *
     * @return mixed
     */
    public function getFileName();
}