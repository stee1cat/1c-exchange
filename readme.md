# commerceml-exchange [![Build Status](https://travis-ci.org/stee1cat/commerceml-exchange.svg?branch=master)](https://travis-ci.org/stee1cat/commerceml-exchange)

## Example

```php
<?php

use stee1cat\CommerceMLExchange\CommerceMLExchange;
use stee1cat\CommerceMLExchange\Config;
use stee1cat\CommerceMLExchange\Event\Events;
use stee1cat\CommerceMLExchange\Catalog\Result;
use stee1cat\CommerceMLExchange\Event\Event;

$config = (new Config())
    ->setUsername('1c_exchange')
    ->setPassword('qwerty')
    ->setZipSupport(false)
    ->setLogPath('./temp/logs')
    ->setUploadPath('./temp/files');


$exchange = new CommerceMLExchange($config);
$exchange->subscribe(Events::ON_IMPORT, function (Event $event) {
    /** @var Result $data */
    $data = $event->getData();
    // import actions
});

$exchange->start();
```