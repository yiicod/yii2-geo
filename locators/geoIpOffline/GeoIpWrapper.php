<?php

namespace yiicod\geo\locators\geoIpOffline;

use Yii;
use yii\base\Component;

/**
 * Class GeoIpWrapper
 *
 * Wrapper to work with geo_ip.
 *
 * Additionally it checks DB-file and download it if need.
 *
 * @package yiicod\geo\locators\geoIpOffline
 *
 * @author Dmitry Turchanin
 */
class GeoIpWrapper extends Component
{
    /**
     * Database alias
     *
     * @var string
     */
    public $databaseAlias = '@app/runtime';
    /**
     * Database alias
     *
     * @var string
     */
    public $databaseFilename = 'GeoIP.dat';

    /**
     * Database full file name
     *
     * @var string
     */
    private $databaseFullFilename;

    /**
     * Object
     *
     * @var \GeoIP
     */
    private $geoIpHolder;

    /**
     * Full data array
     *
     * @var array
     */
    private $fullData = [];

    public function init()
    {
        $this->databaseFullFilename = rtrim(Yii::getAlias($this->databaseAlias), '/') . '/' . $this->databaseFilename;
    }

    /**
     * @param $ip
     *
     * @return mixed
     */
    public function getFullDataByIp($ip)
    {
        if (isset($this->fullData[$ip])) {
            return $this->fullData[$ip];
        }

        $geoIp = $this->getGeoIpObject();

        if (!is_object($geoIp)) {
            $this->fullData[$ip] = false;

            return $this->fullData[$ip];
        }

        $countryCode = geoip_country_code_by_addr($geoIp, $ip);
        $countryName = geoip_country_name_by_addr($geoIp, $ip);

        $this->clearGeoIpObject();

        $this->fullData[$ip] = compact('countryCode', 'countryName');

        return $this->fullData[$ip];
    }

    /**
     * @return \GeoIP|mixed
     */
    private function getGeoIpObject()
    {
        if (is_null($this->geoIpHolder) && $this->hasDbFile()) {
            $this->geoIpHolder = geoip_open($this->databaseFullFilename, GEOIP_STANDARD);
        }

        return $this->geoIpHolder;
    }

    private function clearGeoIpObject()
    {
        if (!is_null($this->geoIpHolder)) {
            geoip_close($this->geoIpHolder);
            $this->geoIpHolder = null;
        }
    }

    /**
     * @param $ip
     *
     * @return $this
     */
    public function resetFullDataByIp($ip)
    {
        unset($this->fullData[$ip]);

        return $this;
    }

    /**
     * Checks if DB-file exists and actual, if not then it starts file update
     *
     * @return bool
     */
    private function hasDbFile()
    {
        $result = false;
        $needUpdateDbFile = true;

        if (file_exists($this->databaseFullFilename) && $modifiedTime = filemtime($this->databaseFullFilename)) {
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
    private function updateDbFile()
    {
        $file = $this->databaseFullFilename;

        $archivePath = str_replace(basename($file), 'GeoIPArchive', $file);
        $tmpPath = str_replace(basename($file), 'GeoIPTmp', $file);
        $downloadUrl = 'http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz';

        $cmd = "rm -f $archivePath"
            . " && wget $downloadUrl -O $archivePath"
            . " && gunzip -c $archivePath > $tmpPath"
            . " && mv -f $tmpPath $file"
            . " && rm -f $archivePath";
        $cmd .= ' 2>&1';

        exec($cmd);
    }
}
