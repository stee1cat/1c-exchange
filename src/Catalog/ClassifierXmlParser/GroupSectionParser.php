<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser;

use stee1cat\CommerceMLExchange\Model\Group;

/**
 * Class GroupSectionParser
 * @package stee1cat\CommerceMLExchange
 */
class GroupSectionParser {

    /**
     * @var \SimpleXMLElement
     */
    protected $root;

    public function __construct(\SimpleXMLElement $root) {
        $this->root = $root;
    }

    /**
     * @return array|Group[]
     */
    public function parse() {
        $result = [];
        $root = $this->root->Классификатор->Группы->children();

        if (count($root)) {
            $result = $this->walk($root);
        }

        return $result;
    }

    /**
     * @param \SimpleXMLElement $nodes
     *
     * @return Group[]
     */
    protected function walk($nodes) {
        $result = [];

        foreach ($nodes as $node) {
            $group = Group::create($node);

            if ($node->Группы) {
                $children = $this->walk($node->Группы->children());

                $group->setGroups($children);
            }

            $result[] = $group;
        }

        return $result;
    }

}