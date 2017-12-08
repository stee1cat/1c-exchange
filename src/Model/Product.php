<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Good
 * @package stee1cat\CommerceMLExchange\Model
 */
class Product {

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    public static function create(\SimpleXMLElement $element) {
        $good = new self();
        $id = (string) $element->Ид;
        $name = (string) $element->Наименование;

        if ($id) {
            $good->setId($id);
        }

        if ($name) {
            $good->setName($name);
        }

        return $good;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Product
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
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
     * @return Product
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

}