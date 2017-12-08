<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser;

use stee1cat\CommerceMLExchange\Catalog\XmlParserInterface;
use stee1cat\CommerceMLExchange\Model\Store;

/**
 * Class StoreSectionParser
 * @package stee1cat\CommerceMLExchange
 */
class StoreSectionParser implements XmlParserInterface {

    /**
     * @var \SimpleXMLElement
     */
    protected $root;

    public function __construct(\SimpleXMLElement $root) {
        $this->root = $root;
    }

    /**
     * @return array|Store[]
     */
    public function parse() {
        $result = [];
        $root = $this->root->Классификатор->Склады->children();

        if (count($root)) {
            $result = $this->walk($root);
        }

        return $result;
    }

    /**
     * @param \SimpleXMLElement $nodes
     *
     * @return Store[]
     */
    protected function walk($nodes) {
        $result = [];

        foreach ($nodes as $node) {
            $store = Store::create($node);

            $result[] = $store;
        }

        return $result;
    }

}