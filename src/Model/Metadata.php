<?php
/**
 * Copyright (c) 2018 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Metadata
 * @package stee1cat\CommerceMLExchange\Model
 */
class Metadata {

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $date;

    /**
     * @param \SimpleXMLElement $element
     *
     * @return Metadata
     */
    public static function create(\SimpleXMLElement $element) {
        $metadata = new self();

        if ($version = $element->xpath('./@ВерсияСхемы')) {
            $metadata->setVersion((string) $version[0]);
        }

        if ($date = $element->xpath('./@ДатаФормирования')) {
            $metadata->setDate((string) $date[0]);
        }

        return $metadata;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return Metadata
     */
    public function setVersion($version) {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return Metadata
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

}