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

    /**
     * @var string[]
     */
    protected $groups = [];

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $vendorCode;

    /**
     * @var boolean
     */
    protected $markAsDelete = false;

    public static function create(\SimpleXMLElement $element) {
        $product = new self();

        if ($id = $element->xpath('./Ид')) {
            $product->setId((string) $id[0]);
        }

        if ($name = $element->xpath('./Наименование')) {
            $product->setName((string) $name[0]);
        }

        if ($description = $element->xpath('./Описание')) {
            $product->setDescription((string) $description[0]);
        }

        if ($vendorCode = $element->xpath('./Артикул')) {
            $product->setVendorCode((string) $vendorCode[0]);
        }

        if ($groups = $element->xpath('./Группы/Ид')) {
            foreach ($groups as $group) {
                $product->addGroup((string) $group);
            }
        }

        if ($markAsDelete = $element->xpath('./ПометкаУдаления')) {
            $product->setMarkAsDelete((string) $markAsDelete[0] === 'true' || (integer) $markAsDelete[0]);
        }

        return $product;
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
        $this->id = trim($id);

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
        $this->name = trim($name);

        return $this;
    }

    /**
     * @return string[]
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * @param string[] $groups
     */
    public function setGroups($groups) {
        $this->groups = [];

        foreach ($groups as  $group) {
            $this->addGroup($group);
        }
    }

    /**
     * @param string $group
     */
    public function addGroup($group) {
        $this->groups[] = trim($group);
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description) {
        $this->description = trim($description);

        return $this;
    }

    /**
     * @return string
     */
    public function getVendorCode() {
        return $this->vendorCode;
    }

    /**
     * @param string $vendorCode
     *
     * @return Product
     */
    public function setVendorCode($vendorCode) {
        $this->vendorCode = trim($vendorCode);

        return $this;
    }

    /**
     * @return boolean
     */
    public function isMarkAsDelete() {
        return $this->markAsDelete;
    }

    /**
     * @param boolean $markAsDelete
     *
     * @return Product
     */
    public function setMarkAsDelete($markAsDelete) {
        $this->markAsDelete = $markAsDelete;

        return $this;
    }

}