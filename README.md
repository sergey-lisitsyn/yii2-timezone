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
<?= $time = (new \nikosmart\timezone\TimezoneDetect(['lat'=>0, 'lng'=>0]))
    ->getTimeByCoords() ?>
can get
$time->hours
and
$time->minutes
```