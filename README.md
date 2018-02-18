Yii Geo position getter extension
=================================

[![Latest Stable Version](https://poser.pugx.org/yiicod/yii2-geo/v/stable)](https://packagist.org/packages/yiicod/yii2-geo) [![Total Downloads](https://poser.pugx.org/yiicod/yii2-geo/downloads)](https://packagist.org/packages/yiicod/yii2-geo) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiicod/yii2-geo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiicod/yii2-geo/?branch=master)[![Code Climate](https://codeclimate.com/github/yiicod/yii2-geo/badges/gpa.svg)](https://codeclimate.com/github/yiicod/yii2-geo)

This extension will help you to find user country and country code.
It use two online and one offline system for find information about user. You no need worry
what system will use because all of this will do one component GeoFinder

#### Installation

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

#### Config for frontend
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

#### Usage
```php
\yiicod\geo\GeoGetter::getCountryName()
\yiicod\geo\GeoGetter::getCountryCode()
````
