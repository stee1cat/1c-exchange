<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser\GroupSectionParser;
use stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser\StoreSectionParser;

/**
 * Class ClassifierXmlXmlParser
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class ClassifierXmlParser implements XmlParserInterface {

    /**
     * @var GroupSectionParser
     */
    protected $groupSectionParser;

    /**
     * @var StoreSectionParser
     */
    protected $storeSectionParser;

    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    public function __construct(\SimpleXMLElement $xml) {
        $this->xml = $xml;
    }

    /**
     * @return Result
     */
    public function parse() {
        $result = new Result();

        if (!$this->groupSectionParser) {
            $this->groupSectionParser = new GroupSectionParser($this->xml);
        }

        if (!$this->storeSectionParser) {
            $this->storeSectionParser = new StoreSectionParser($this->xml);
        }

        $result->setGroups($this->groupSectionParser->parse());
        $result->setStores($this->storeSectionParser->parse());

        return $result;
    }

}
