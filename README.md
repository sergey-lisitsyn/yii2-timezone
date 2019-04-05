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
<?= \nikosmart\timezone\AutoloadExample::widget(); ?>```


To enable it in your application, you need to create a git repository and require it via composer.

cd /home/sergey/http/www/grand-expert.loc/extensions/nikosmart/yii2-timezone

git init
git add -A
git commit
git remote add origin https://path.to/your/repo
git push -u origin master

The next step is just for initial development, skip it if you directly publish the extension on packagist.org

Add the newly created repo to your composer.json.

"repositories":[
    {
        "type": "git",
        "url": "https://path.to/your/repo"
    }
]

Note: You may use the url file:///home/sergey/http/www/grand-expert.loc/extensions/nikosmart/yii2-timezone for testing.

Require the package with composer

composer.phar require nikosmart/yii2-timezone:dev-master

And use it in your application.

\nikosmart\timezone\AutoloadExample::widget(); 