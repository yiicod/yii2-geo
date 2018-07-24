<?php

namespace yiicod\geo;

use Yii;
use yiicod\geo\base\GeoFinderInterface;

/**
 * Class GeoGetter
 *
 * @package yiicod\geo
 *
 * @author Alexey Orlov
 * @author Dmitry Turchanin
 */
class GeoGetter
{
    /**
     * Gets country code by IP
     *
     * @param null|string
     *
     * @return null|string
     */
    public static function getCountryCode($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getCountryCode($ip);
    }

    /**
     * Gets country name by IP
     *
     * @param null|string
     *
     * @return null|string
     */
    public static function getCountryName($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getCountryName($ip);
    }

    /**
     * Gets region by IP
     *
     * @param null|string $ip
     *
     * @return null|string
     */
    public static function getRegion($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getRegion($ip);
    }

    /**
     * Gets region name by IP
     *
     * @param null|string $ip
     *
     * @return null|string
     */
    public static function getRegionName($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getRegionName($ip);
    }

    /**
     * Gets region code by IP
     *
     * @param null|string $ip
     *
     * @return null|string
     */
    public static function getRegionCode($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getRegionCode($ip);
    }

    /**
     * Gets city by IP
     *
     * @param null|string $ip
     *
     * @return null|string
     */
    public static function getCity($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getCity($ip);
    }

    /**
     * Gets latitude by IP
     *
     * @param null|string $ip
     *
     * @return null|string
     */
    public static function getLatitude($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getLatitude($ip);
    }

    /**
     * Gets longitude by IP
     *
     * @param null|string $ip
     *
     * @return null|string
     */
    public static function getLongitude($ip = null): ?string
    {
        $ip = $ip ?? Yii::$app->request->getUserIP();

        return static::getGeoManager()->getLongitude($ip);
    }

    /**
     * Returns geo component
     *
     * @return GeoFinderInterface
     */
    public static function getGeoManager(): GeoFinderInterface
    {
        return Yii::$app->geoFinder;
    }
}
