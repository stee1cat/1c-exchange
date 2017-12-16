<?php

use Codeception\Util\Autoload;

$baseDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'src';

Autoload::addNamespace('stee1cat\CommerceMLExchange', $baseDir);

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'helpers.php';