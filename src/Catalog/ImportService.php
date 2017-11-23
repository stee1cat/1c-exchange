<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Model\Group;
use stee1cat\CommerceMLExchange\Model\Store;

/**
 * Class ImportService
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class ImportService {

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var Group[]
     */
    protected $groups;

    /**
     * @var Store[]
     */
    protected $stores;

    public function import($filename) {
        $this->filename = $filename;

        $this->load($this->filename);
    }

    public function parse($content) {
        $classifierParser = new ClassifierXmlParser($content);
        $this->groups = $classifierParser->getGroups();
        $this->stores = $classifierParser->getStores();
    }

    public function load($filename) {
        $this->content = file_get_contents($filename);
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

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

}