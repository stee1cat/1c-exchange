<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use stee1cat\CommerceMLExchange\Catalog\ImportService;
use stee1cat\CommerceMLExchange\EventDispatcher;
use stee1cat\CommerceMLExchange\Http\Request;
use stee1cat\CommerceMLExchange\Logger;

return [
    Logger::class => \DI\object(Logger::class),
    Request::class => \DI\object(Request::class),
    ImportService::class => \DI\object(ImportService::class),
    EventDispatcher::class => \DI\object(EventDispatcher::class),
];