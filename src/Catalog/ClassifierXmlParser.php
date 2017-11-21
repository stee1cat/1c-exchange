<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser\GroupSectionParser;
use stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser\StoreSectionParser;

/**
 * Class ClassifierXmlParser
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class ClassifierXmlParser {

    /**
     * @var string
     */
    protected $data;

    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    public function __construct($data) {
        $this->data = $data;
        $this->xml = simplexml_load_string($data);
    }

    /**
     * @return array|Group[]
     */
    public function getGroups() {
        $parser = new GroupSectionParser($this->xml);

        return $parser->parse();
    }

    /**
     * @return array|Store[]
     */
    public function getStores() {
        $parser = new StoreSectionParser($this->xml);

        return $parser->parse();
    }

}
