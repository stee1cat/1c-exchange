<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as MonoLogger;

/**
 * Class Logger
 * @package stee1cat\CommerceMLExchange
 */
class Logger {

    /**
     * @var MonoLogger
     */
    protected $logger;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $name = '1c-exchange';

    public function __construct(Config $config) {
        $this->config = $config;

        $formatter = new LineFormatter(null, null, false, true);

        $rotating = new RotatingFileHandler($this->getLogFilename());
        $rotating->setFormatter($formatter);

        $this->logger = new MonoLogger($this->name);
        $this->logger->pushHandler($rotating);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function info($message, $context = []) {
        $this->logger->info($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function notice($message, $context = []) {
        $this->logger->notice($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function error($message, $context = []) {
        $this->logger->error($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function debug($message, $context = []) {
        $this->logger->debug($message, $context);
    }

    protected function getLogFilename() {
        return $this->config->getLogPath() . DIRECTORY_SEPARATOR . $this->name . '.log';
    }

}