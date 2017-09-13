<?php

namespace yiicod\geo;

use Yii;
use yiicod\geo\base\LocatorInterface;

/**
 * Created by PhpStorm.
 * User: lexx
 * Date: 12/28/16
 * Time: 8:33 PM
 */
class GeoGetter
{
    /**
     * Gets country code by IP
     *
     * @param string|null
     *
     * @return string
     */
    public static function getCountryCode($ip = null)
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getCountryCode($ip);
    }

    /**
     * Gets country name by IP
     *
     * @param string|null
     *
     * @return string
     */
    public static function getCountryName($ip = null)
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getCountryName($ip);
    }

    /**
     * @return LocatorInterface
     */
    public static function getGeoManager()
    {
        return Yii::$app->geoFinder;
    }
}
