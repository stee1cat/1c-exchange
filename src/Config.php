<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

/**
 * Class Config
 * @package stee1cat\CommerceMLExchange
 */
final class Config {

    /**
     * @var string
     */
    protected $uploadPath;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var boolean
     */
    protected $isZipSupport = false;

    /**
     * @var integer
     */
    protected $fileSizeLimit = 20000000;

    /**
     * @var string
     */
    protected $logPath;

    /**
     * @return string
     */
    public function getUploadPath() {
        return $this->uploadPath;
    }

    /**
     * @param string $uploadPath
     *
     * @return Config
     */
    public function setUploadPath($uploadPath) {
        $this->uploadPath = $uploadPath;

        return $this;
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
     * @return Config
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
     * @return Config
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isZipSupport() {
        return $this->isZipSupport;
    }

    /**
     * @param boolean $isZipSupport
     *
     * @return Config
     */
    public function setZipSupport($isZipSupport) {
        $this->isZipSupport = $isZipSupport;

        return $this;
    }

    /**
     * @return integer
     */
    public function getFileSizeLimit() {
        return $this->fileSizeLimit;
    }

    /**
     * @param integer $fileSizeLimit
     *
     * @return Config
     */
    public function setFileSizeLimit($fileSizeLimit) {
        $this->fileSizeLimit = $fileSizeLimit;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogPath() {
        return $this->logPath ? $this->logPath : getcwd();
    }

    /**
     * @param string $logPath
     *
     * @return Config
     */
    public function setLogPath($logPath) {
        $this->logPath = $logPath;

        return $this;
    }

}