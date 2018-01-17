<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Catalog\Exception\CatalogLoadException;
use stee1cat\CommerceMLExchange\Event\Event;
use stee1cat\CommerceMLExchange\Event\Events;
use stee1cat\CommerceMLExchange\EventDispatcher;
use stee1cat\CommerceMLExchange\Logger;
use stee1cat\CommerceMLExchange\Model\Metadata;
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
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(EventDispatcher $eventDispatcher, Logger $logger) {
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
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

            if ($parser) {
                $result = $parser->parse();

                if ($metadata = $this->parseMetadata()) {
                    $result->setMetadata($metadata);
                }

                $this->eventDispatcher->dispatch(Events::ON_IMPORT, new Event($result));
            }
            else {
                $this->logger->notice('Parser not found', [
                    'filename' => $file,
                ]);
            }
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
     * @return Metadata|null
     */
    protected function parseMetadata() {
        if ($this->xml) {
            return Metadata::create($this->xml);
        }
    }

    /**
     * @return XmlParserInterface|boolean
     */
    protected function createParser() {
        $filename = basename($this->file);

        if (preg_match('/import_.*\.xml$/i', $filename)) {
            $this->xml = $this->createXml();

            if ($this->isClassifier($this->xml)) {
                return new ClassifierXmlParser($this->xml);
            }
            else if ($this->isCatalog($this->xml)) {
                return new CatalogXmlParser($this->xml);
            }
        }
        else if (preg_match('/(prices|rests)_.*\.xml$/i', $filename)) {
            $this->xml = $this->createXml();

            return new OfferXmlParser($this->xml);
        }

        return false;
    }

    /**
     * @return \SimpleXMLElement
     */
    protected function createXml() {
        $string = Xml::removeNs($this->raw);

        return simplexml_load_string($string);
    }

}