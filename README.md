Define timezone by the coordinates
==================================
Timezone client based on Google Timezone APIs with the possibility of extension with another providers.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nikosmart/yii2-timezone "*"
```

or add

```
"nikosmart/yii2-timezone": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= $time = (new \nikosmart\timezone\TimezoneDetect())
    ->request([
        'lat'=>46.965900,
        'lng'=>31.997400
    ]);
?>
According to google 
Calculating the Local Time

The local time of a given location is the sum of the timestamp parameter, 
and the dstOffset and rawOffset fields from the result.
```