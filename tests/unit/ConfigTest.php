<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Config;

/**
 * Class ConfigTest
 */
class ConfigTest extends Unit {

    use Specify;

    /**
     * @var Config
     */
    protected $config;

    protected function _before() {
        $this->config = new Config();
    }

    public function testDefaultLogPath() {
        $this->assertTrue($this->config->getLogPath() === getcwd());
    }

    public function testCustomLogPath() {
        $this->specify('Log path must be equals', function () {
            $logPath = __DIR__ . DIRECTORY_SEPARATOR . 'logs';
            $this->config->setLogPath($logPath);

            $this->assertTrue($this->config->getLogPath() === $logPath);
        });
    }

}