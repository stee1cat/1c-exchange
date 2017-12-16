<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

/**
 * Class Xml
 * @package stee1cat\CommerceMLExchange
 */
class Xml {

    public static function removeNs($string) {
        return preg_replace('/xmlns[^=]*="[^"]*"\s+/i', '', $string);
    }

}