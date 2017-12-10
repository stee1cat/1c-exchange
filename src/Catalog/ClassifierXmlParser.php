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

    /**
     * @var Group[]
     */
    protected $groups = [];

    /**
     * @var Store[]
     */
    protected $stores = [];

    public function __construct(\SimpleXMLElement $xml) {
        $this->xml = $xml;
    }

    public function parse() {
        if (!$this->groupSectionParser) {
            $this->groupSectionParser = new GroupSectionParser($this->xml);
        }

        if (!$this->storeSectionParser) {
            $this->storeSectionParser = new StoreSectionParser($this->xml);
        }

        $this->groups = $this->groupSectionParser->parse();
        $this->stores = $this->storeSectionParser->parse();
    }

    /**
     * @return Group[]
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * @return Store[]
     */
    public function getStores() {
        return $this->stores;
    }

}
