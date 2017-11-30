<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Http;

/**
 * Class AuthData
 * @package stee1cat\CommerceMLExchange\Http
 */
class AuthData {

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return AuthData
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return AuthData
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

}