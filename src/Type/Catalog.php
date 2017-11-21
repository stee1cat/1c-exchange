<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Type;

use stee1cat\CommerceMLExchange\Config;

/**
 * Class Catalog
 * @package stee1cat\CommerceMLExchange
 */
class Catalog {

    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    public function start() {

    }

}