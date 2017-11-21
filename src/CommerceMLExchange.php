<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

use stee1cat\CommerceMLExchange\Di\Container;

/**
 * Class CommerceMLExchange
 * @package stee1cat\CommerceMLExchange
 *
 * @see http://v8.1c.ru/edi/edi_stnd/131/
 */
class CommerceMLExchange {

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Container
     */
    protected $container;

    public function __construct(Config $config) {
        $this->container = new Container($config);
        $this->config = $config;

        $this->bootstrap();
    }

    public function start() {
        $controller = new Controller($this->container, $this->config);
        $controller->beforeAction();

        if (isset($_GET['type']) && isset($_GET['mode'])) {
            switch (strtolower($_GET['mode'])) {
                case 'checkauth':
                    $controller->stageCheckauth();
                    break;
                case 'init':
                    $controller->stageInit();
                    break;
                case 'file':
                    $controller->stageUpload();
                    break;
                case 'import':
                    $controller->stageImport();
                    break;
                default:
                    $controller->unknownCommandAction();
            }
        }
        else {
            $controller->emptyCommandAction();
        }

        $controller->afterAction();
    }

    protected function bootstrap() {
        session_start();
    }

}