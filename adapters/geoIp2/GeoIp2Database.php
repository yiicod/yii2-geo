<?php

namespace yiicod\geo\adapters\geoIp2;

use Yii;

/**
 * Class GeoIp2Database
 *
 * @package yiicod\geo\adapters\geoIp2
 *
 * @author Dmitry Turchanin
 */
class GeoIp2Database implements GeoIpDatabaseInterface
{
    /**
     * Database alias
     *
     * @var string
     */
    public $databaseAlias = '@app/runtime';

    /**
     * GeoLite database download URL
     *
     * @var string
     */
    public $databaseDownloadUrl = 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz';

    /**
     * Database alias
     *
     * @var string
     */
    public $databaseFilename = 'GeoLite2-City.mmdb';

    /**
     * Database full file name
     *
     * @var string
     */
    private $databaseFullFilename;

    /**
     * Checks if DB-file exists and it is actual. Ff not then it starts file update
     *
     * @return bool
     */
    public function hasDbFile(): bool
    {
        $result = false;
        $needUpdateDbFile = true;

        if (file_exists($this->getFileName()) && $modifiedTime = filemtime($this->getFileName())) {
            $result = true;

            if ((time() - $modifiedTime) < 30 * 24 * 3600) {
                $needUpdateDbFile = false;
            }
        }

        if (true === $needUpdateDbFile) {
            $this->updateDbFile();
        }

        return $result;
    }

    /**
     * Downloads and unpacks fresh IP database file in the background process
     */
    public function updateDbFile()
    {
        $file = $this->getFileName();

        $archivePath = str_replace(basename($file), 'GeoIPArchive', $file);
        $tmpPath = str_replace(basename($file), 'GeoIPTmp', $file);
        $downloadUrl = $this->databaseDownloadUrl;

        $cmd = "rm -f $archivePath"
            . " && wget $downloadUrl -O $archivePath"
            . " && gunzip -c $archivePath > $tmpPath"
            . " && mv -f $tmpPath $file"
            . " && rm -f $archivePath";
        $cmd .= ' 2>&1';

        exec($cmd);
    }

    /**
     * Gets local database's file name
     *
     * @return string
     */
    public function getFileName()
    {
        if (is_null($this->databaseFullFilename)) {
            $this->databaseFullFilename = rtrim(Yii::getAlias($this->databaseAlias), '/') . '/' . $this->databaseFilename;
        }

        return $this->databaseFullFilename;
    }
}
