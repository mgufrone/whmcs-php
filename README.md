[![Coverage Status](https://coveralls.io/repos/mgufrone/whmcs-php/badge.svg?branch=master)](https://coveralls.io/r/mgufrone/whmcs-php?branch=master)
[![Build Status](https://travis-ci.org/mgufrone/whmcs-php.svg?branch=master)](https://travis-ci.org/mgufrone/whmcs-php)

# Unofficial WHMCS PHP API Package

This package is bring for you who use whmcs so much and yet, you need some of their API.

## Installation

To install this package, a simple thing you need to do is run this command in your terminal or command line
```shell
  composer require gufy/whmcs-php:~1
```
Or if you already have a project and you need some package to run WHMCS API, change your `composer.json` and then add this line
```json
  {
    "require":{
      ...
      "gufy/whmcs-php":"~1"
      ...
    }
  }
```

Then run composer update in your terminal or similar to it.

# Usage

Here is how you use it.

```php
<?php
use Gufy\WhmcsPhp\Config;
use Gufy\WhmcsPhp\Whmcs;

$config = new Config([
  'baseUrl'=>'http://yourwhmcs/includes/api.php',
  'username'=>'your_username',
  'password'=>'your_password'
]);


$whmcs = new Whmcs($config);

// Get Clients
$clients = $whmcs->getclients();


// get client by id
$invoice = $whmcs->getinvoice(['invoiceid'=>1023]);
```

If you prefer using api keys instead of user password, change the configuration like this.

```php
<?php

use Gufy\WhmcsPhp\Config;
use Gufy\WhmcsPhp\Whmcs;

$config = new Config([
  'baseUrl'=>'http://yourwhmcs/includes/api.php',
  'username'=>'your_username',
  'password'=>'your_api_keys',
  'authType'=>'keys'
]);

$whmcs = new Whmcs($config);

```

Just call all action which is already defined at [WHMCS Developer Documentation](http://docs.whmcs.com/API)


# Feedback & Contribution

Love this package? You can add some star to this package or if you have any ideas about improving this package, just fork it and make a pull request. Thank you. :+1:
