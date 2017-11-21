<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

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
        $id = (string) $element->Ид;
        $name = (string) $element->Наименование;
        $comment = (string) $element->Комментарий;

        if ($id) {
            $store->setId($id);
        }

        if ($name) {
            $store->setName($name);
        }

        if ($comment) {
            $store->setComment($comment);
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