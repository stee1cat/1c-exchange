<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

use stee1cat\CommerceMLExchange\Di\Container;
use stee1cat\CommerceMLExchange\Http\Request;

/**
 * Class AbstractController
 * @package stee1cat\CommerceMLExchange
 */
abstract class AbstractController {

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(Container $container, Config $config) {
        $this->container = $container;
        $this->logger = $container->get(Logger::class);
        $this->config = $config;
    }

    public function beforeAction() {
        /** @var Request $request */
        $request = $this->container->get(Request::class);

        $this->logger->info(sprintf('> %s %s', $request->getMethod(), $request->getUri()));
    }

    public function afterAction() {
        // nope
    }

    public function unknownCommandAction() {
        $this->failure('Unknown command type');
    }

    public function emptyCommandAction() {
        $this->failure('Empty command type or mode');
    }

    protected function success($message = '') {
        $this->message('success' . PHP_EOL);
        $this->message($message);

        $this->logger->info('< SUCCESS' . ($message ?  ' ' : '') . $message);
    }

    protected function failure($message = '') {
        $this->message('failure' . PHP_EOL);
        $this->message($message);

        $this->logger->error('< FAILURE' . ($message ?  ' ' : '') . $message);
    }

    protected function progress($message = '') {
        $this->message('progress' . PHP_EOL);
        $this->message($message);
    }

    protected function message($message) {
        echo $message;
    }

}