<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */
namespace stee1cat\CommerceMLExchange\Di;

use DI\ContainerBuilder;
use DI\Container as DiContainer;
use stee1cat\CommerceMLExchange\Config;

/**
 * Class Container
 * @package stee1cat\CommerceMLExchange\Di
 */
class Container {

    /**
     * @var DiContainer
     */
    protected $container;

    public function __construct(Config $config) {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            Config::class => $config,
            __DIR__ . DIRECTORY_SEPARATOR . 'config.php',
        ]);

        $this->container = $builder->build();
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function get($name) {
        return $this->container->get($name);
    }

}