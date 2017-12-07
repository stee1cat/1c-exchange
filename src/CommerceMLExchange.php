<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

use stee1cat\CommerceMLExchange\Di\Container;
use stee1cat\CommerceMLExchange\Http\Request;

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
        $controller = new Controller($this->container);

        try {
            $controller->beforeAction();

            /** @var Request $request */
            $request = $this->container->get(Request::class);

            if ($request->get('type') && $request->get('mode')) {
                switch (strtolower($request->get('mode'))) {
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
                    case 'complete':
                        $controller->stageComplete();
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
        catch (\Exception $exception) {
            $controller->internalServerErrorAction($exception);
        }

    }

    protected function bootstrap() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

}