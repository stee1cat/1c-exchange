<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser;

use stee1cat\CommerceMLExchange\Catalog\XmlParserInterface;
use stee1cat\CommerceMLExchange\Model\Group;

/**
 * Class GroupSectionParser
 * @package stee1cat\CommerceMLExchange
 */
class GroupSectionParser implements XmlParserInterface {

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
        $groups = $this->root->xpath('./Классификатор/Группы/Группа');

        if (count($groups)) {
            $result = $this->walk($groups);
        }

        return $result;
    }

    /**
     * @param \SimpleXMLElement[] $nodes
     *
     * @return Group[]
     */
    protected function walk($nodes) {
        $result = [];

        foreach ($nodes as $node) {
            $group = Group::create($node);

            if ($groups = $node->xpath('./Группы/Группа')) {
                $children = $this->walk($groups);

                $group->setGroups($children);
            }

            $result[] = $group;
        }

        return $result;
    }

}