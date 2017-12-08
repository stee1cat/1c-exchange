<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

/**
 * Interface XmlParserInterface
 * @package stee1cat\CommerceMLExchange\Catalog
 */
interface XmlParserInterface {

    public function __construct(\SimpleXMLElement $xml);
    public function parse();

}