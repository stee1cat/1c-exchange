<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Catalog;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Catalog\ClassifierXmlParser;

/**
 * Class ClassifierXmlParserTest
 * @package Catalog
 */
class ClassifierXmlParserTest extends Unit {

    use Specify;

    /**
     * @var ClassifierXmlParser
     */
    protected $tester;

    protected function _before() {
        $filename = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'import___29d3f7f0-36dd-4eea-a06c-4c325bed4285.xml';
        $xml = simplexml_load_file($filename);

        $this->tester = new ClassifierXmlParser($xml);
    }

    public function testParse() {
        $this->tester->parse();

        $this->specify('Groups', function () {
            $groups = $this->tester->getGroups();
            $firstGroup = $groups[0];

            $this->assertEquals(1, count($groups));
            $this->assertEquals(11, count($firstGroup->getGroups()));
        });

        $this->specify('Stores', function () {
            $stores = $this->tester->getStores();
            $firstStore = $stores[0];

            $this->assertEquals(13, count($stores));
            $this->assertEquals('Домодедовская таможня', $firstStore->getName());
        });
    }

}