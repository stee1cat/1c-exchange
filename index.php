<?php

require 'vendor/autoload.php';

use stee1cat\CommerceMLExchange\CommerceMLExchange;
use stee1cat\CommerceMLExchange\Config;

function autoload($class) {
    $prefix = 'stee1cat\\CommerceMLExchange\\';
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    $length = strlen($prefix);

    if (strncmp($prefix, $class, $length) !== 0) {
        return;
    }

    $relativeClass = substr($class, $length);
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('autoload');

$config = new Config();
$config->setUsername('1c_exchange')
    ->setPassword('qwerty')
    ->setZipSupport(false)
    ->setFileSizeLimit(5000)
    ->setLogPath(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'logs')
    ->setUploadPath(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'files');

$exchange = new CommerceMLExchange($config);
$exchange->start();