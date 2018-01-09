<?php
/**
 * Copyright (c) 2018 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Validator;

/**
 * Class FilenameValidator
 * @package stee1cat\CommerceMLExchange\Validator
 */
class FilenameValidator implements ValidatorInterface {

    /**
     * @var string
     */
    protected $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function validate() {
        return !!preg_match('/^([0-9a-zA-Z_\-.\/]+)$|^([^\/]+\.zip)$/i', $this->filename);
    }

}