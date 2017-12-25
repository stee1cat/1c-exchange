<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Catalog\Exception\CatalogLoadException;
use stee1cat\CommerceMLExchange\Event\Event;
use stee1cat\CommerceMLExchange\EventDispatcher;
use stee1cat\CommerceMLExchange\Xml;

/**
 * Class ImportService
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class ImportService {

    /**
     * @var string
     */
    protected $raw;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher) {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $file
     *
     * @throws CatalogLoadException
     */
    public function import($file) {
        $this->file = $file;

        if ($this->load($file)) {
            $parser = $this->createParser();
            $result = $parser->parse();

            $this->eventDispatcher->dispatch('parse', new Event($result));
        }
        else {
            throw new CatalogLoadException();
        }
    }

    public function load($file) {
        $this->raw = file_get_contents($file);

        return !!$this->raw;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->raw;
    }

    public function isClassifier(\SimpleXMLElement $xml) {
        return !!$xml->xpath('./Классификатор/Ид');
    }

    public function isCatalog(\SimpleXMLElement $xml) {
        return !!$xml->xpath('./Каталог/Ид');
    }

    /**
     * @return XmlParserInterface
     */
    protected function createParser() {
        $filename = basename($this->file);

        if (preg_match('/import_.*\.xml$/i', $filename)) {
            $xml = $this->createXml();

            if ($this->isClassifier($xml)) {
                return new ClassifierXmlParser($xml);
            }
            else if ($this->isCatalog($xml)) {
                return new CatalogXmlParser($xml);
            }
        }
        else if (preg_match('/prices_.*\.xml$/i', $filename)) {
            $xml = $this->createXml();

            return new PriceXmlParser($xml);
        }
    }

    /**
     * @return \SimpleXMLElement
     */
    protected function createXml() {
        $string = Xml::removeNs($this->raw);

        return simplexml_load_string($string);
    }

}