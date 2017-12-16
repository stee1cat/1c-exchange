<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use stee1cat\CommerceMLExchange\Xml;

function loadXmlFile($filename) {
    $raw = file_get_contents($filename);

    return loadXmlString($raw);
}

function loadXmlString($raw) {
    $string = Xml::removeNs($raw);

    return simplexml_load_string($string);
}