# Installation

The preferred way to install the extension is using [composer](http://getcomposer.org/).
Create a folder named `PayumYiiExtension` in the extensions directory of your Yii project
and then create a _composer.json_ file with the following content:

```json
{
    "require": {
        "payum/payum-yii-extension": "@stable",
        "payum/xxx": "@stable"
    }
}
```

Then run composer update:

```bash
php composer.phar update payum/payum-yii-extension payum/xxx
```

_**Note**: Where payum/xxx is a payum package, for example it could be payum/paypal-express-checkout-nvp. Look at [supported payments](https://github.com/Payum/Core/blob/master/Resources/docs/supported-payments.md) to find out what you can use._

_**Note**: Use payum/payum if you want to install all payments at once._

Now you have all required code downloaded.
Next step would be to configure composer autoloader.
You have to register it inside _config/main.php_ or _config/console.php_ for the web and cli 
versions, respectively.

```php
<?php
// app/config/main.php

Yii::setPathOfAlias('Payum', dirname(__FILE__).'/../extensions/PayumYiiExtension/vendor');
Yii::setPathOfAlias('Payum.YiiExtension', Yii::getPathOfAlias('Payum').'/payum/payum-yii-extension/src/Payum/YiiExtension');
Yii::import('Payum.autoload', true);

// ...
```

Now you are ready to [get it started](get-it-started.md).

Back to [index](index.md).
