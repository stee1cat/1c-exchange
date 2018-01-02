<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Group
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class Group {

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Group[]
     */
    protected $groups;

    /**
     * @var boolean
     */
    protected $markAsDelete = false;

    /**
     * @param \SimpleXMLElement $element
     *
     * @return Group
     */
    public static function create(\SimpleXMLElement $element) {
        $group = new self();

        if ($id = $element->xpath('./Ид')) {
            $group->setId((string) $id[0]);
        }

        if ($name = $element->xpath('./Наименование')) {
            $group->setName((string) $name[0]);
        }

        if ($markAsDelete = $element->xpath('./ПометкаУдаления')) {
            $group->setMarkAsDelete((string) $markAsDelete[0] === 'true' || (integer) $markAsDelete[0]);
        }

        return $group;
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
     * @return Group
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Group[]
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * @param Group[] $groups
     *
     * @return Group
     */
    public function setGroups($groups) {
        $this->groups = $groups;

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
     * @return Group
     */
    public function setName($name) {
        $this->name = $name;

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
     * @return Group
     */
    public function setMarkAsDelete($markAsDelete) {
        $this->markAsDelete = $markAsDelete;

        return $this;
    }

}