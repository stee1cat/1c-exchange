<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Http;

/**
 * Class Request
 * @package stee1cat\CommerceMLExchange\Http
 */
class Request {

    /**
     * @var mixed[]
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $environment = [];

    public function __construct($environment = []) {
        $this->environment = empty($environment) ? $_SERVER : $environment;

        $this->parseRequestUri();
    }

    /**
     * @param string $key
     * @param null $defaultValue
     *
     * @return mixed|null
     */
    public function get($key, $defaultValue = null) {
        $result = $defaultValue;

        if (isset($this->params[$key])) {
            $result = $this->params[$key];
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->environment['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getUri() {
        return $this->environment['REQUEST_URI'];
    }

    protected function parseRequestUri() {
        $parts = parse_url($this->environment['REQUEST_URI']);

        if (isset($parts['query'])) {
            parse_str($parts['query'], $this->params);
        }
    }

}