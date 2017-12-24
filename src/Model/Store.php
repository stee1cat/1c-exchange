<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Store
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class Store {

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @param \SimpleXMLElement $element
     *
     * @return Store
     */
    public static function create(\SimpleXMLElement $element) {
        $store = new self();

        if ($id = $element->xpath('./Ид')) {
            $store->setId((string) $id[0]);
        }

        if ($name = $element->xpath('./Наименование')) {
            $store->setName((string) $name[0]);
        }

        if ($comment = $element->xpath('./Комментарий')) {
            $store->setComment((string) $comment[0]);
        }

        return $store;
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
     * @return Store
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
     * @return Store
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return Store
     */
    public function setComment($comment) {
        $this->comment = $comment;

        return $this;
    }

}