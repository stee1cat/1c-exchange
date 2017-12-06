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

    /**
     * @return string[]
     */
    public function getEnvironment() {
        return $this->environment;
    }

    /**
     * @return AuthData
     */
    public function getAuthData() {
        $environment = $this->environment;
        $authorizationVariable = $this->findAuthorizationVariable();

        if (empty($environment['PHP_AUTH_USER']) && $authorizationVariable) {
            $auth = base64_decode(substr($authorizationVariable, 6));

            if ($auth) {
                list($environment['PHP_AUTH_USER'], $environment['PHP_AUTH_PW']) = explode(':', $auth);
            }
        }

        $username = isset($environment['PHP_AUTH_USER']) ? $environment['PHP_AUTH_USER'] : '';
        $password = isset($environment['PHP_AUTH_PW']) ? $environment['PHP_AUTH_PW'] : '';

        return new AuthData($username, $password);
    }

    /**
     * @return string|null
     */
    protected function findAuthorizationVariable() {
        $variables = ['REMOTE_USER', 'REDIRECT_REMOTE_USER', 'HTTP_AUTHORIZATION', 'REDIRECT_HTTP_AUTHORIZATION'];

        foreach ($variables as $variable) {
            if (isset($this->environment[$variable])) {
                return $this->environment[$variable];
            }
        }

        return null;
    }

    protected function parseRequestUri() {
        $parts = parse_url($this->environment['REQUEST_URI']);

        if (isset($parts['query'])) {
            parse_str($parts['query'], $this->params);
        }
    }

}