<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser\GroupSectionParser;
use stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser\StoreSectionParser;
use stee1cat\CommerceMLExchange\Model\Group;
use stee1cat\CommerceMLExchange\Model\Store;

/**
 * Class ClassifierXmlParser
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class ClassifierXmlParser {

    /**
     * @var string
     */
    protected $content;

    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    public function __construct($content) {
        $this->content = $content;
        $this->xml = simplexml_load_string($content);
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
