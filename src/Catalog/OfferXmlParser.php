<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Model\Offer;

/**
 * Class OfferXmlParser
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class OfferXmlParser implements XmlParserInterface {

    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    public function __construct(\SimpleXMLElement $xml) {
        $this->xml = $xml;
    }

    public function parse() {
        $result = new Result();

        if ($elements = $this->xml->xpath('./ПакетПредложений/Предложения/Предложение')) {
            $offers = $this->walk($elements);

            $result->setOffers($offers);
        }

        return $result;
    }

    /**
     * @param \SimpleXMLElement[] $nodes
     *
     * @return Offer[]
     */
    protected function walk($nodes) {
        $result = [];

        foreach ($nodes as $node) {
            $result[] = Offer::create($node);
        }

        return $result;
    }

}