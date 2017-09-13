Geo position getter extension (Yii 2)
=====================================

This extension will help you to find user country and country code.
It use two online and one offline system for find information about user. You no need worry
what system will use because all of this will do one component GeoFinder

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiicod/yii2-geo "*"
```

or add

```json
"yiicod/yii2-geo": "*"
```

to the require section of your composer.json.

Config for frontend
-------------------
```php
'components' => [
    'geoFinder' => [
        'class' => yiicod\geo\components\GeoFinder::class,
        'gettersList' => [
            [
                'class' => \yiicod\geo\components\locators\geoIpOffline\GeoIpOfflineLocator::class,
                'geoIpConfig' => [
                    'class' => \yiicod\geo\components\locators\geoIpOffline\GeoIpWrapper::class,
                    'databaseAlias' => '@frontend/runtime'
                ]
            ],
            [
                'class' => \yiicod\geo\components\locators\freeGeoIp\FreeGeoIpLocator::class
            ]
        ],
    ],
],

```

Usage
-----
```php
\yiicod\geo\GeoGetter::getCountryName()
\yiicod\geo\GeoGetter::getCountryCode()
````
