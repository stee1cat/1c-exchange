<?php
/**
 * Copyright (c) 2018 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Property
 * @package stee1cat\CommerceMLExchange\Model
 */
class Property {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    public static function create(\SimpleXMLElement $element) {
        $property = new self();

        if ($name = $element->xpath('./Наименование')) {
            $property->setName((string) $name[0]);
        }

        if ($value = $element->xpath('./Значение')) {
            $property->setValue((string) $value[0]);
        }

        return $property;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Property
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return Property
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

}