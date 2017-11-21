<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

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
     * @param \SimpleXMLElement $element
     *
     * @return Group
     */
    public static function create(\SimpleXMLElement $element) {
        $group = new self();
        $id = (string) $element->Ид;
        $name = (string) $element->Наименование;

        if ($id) {
            $group->setId($id);
        }

        if ($name) {
            $group->setName($name);
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

}