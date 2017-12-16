<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Model\Product;

/**
 * Class CatalogXmlParser
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class CatalogXmlParser implements XmlParserInterface {

    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    public function __construct(\SimpleXMLElement $xml) {
        $this->xml = $xml;
    }

    public function parse() {
        $result = new Result();

        if ($elements = $this->xml->xpath('./Каталог/Товары/Товар')) {
            $products = $this->walk($elements);

            $result->setProducts($products);
        }

        return $result;
    }

    /**
     * @param \SimpleXMLElement[] $nodes
     *
     * @return Product[]
     */
    protected function walk($nodes) {
        $result = [];

        foreach ($nodes as $node) {
            $result[] = Product::create($node);
        }

        return $result;
    }

}