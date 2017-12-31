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
        $xml = loadXmlFile($filename);

        $this->tester = new ClassifierXmlParser($xml);
    }

    public function testParse() {
        $result = $this->tester->parse();

        $this->specify('groups', function () use ($result) {
            $groups = $result->getGroups();
            $firstGroup = $groups[0];

            $this->assertCount(1, $groups);
            $this->assertCount(11, $firstGroup->getGroups());
        });

        $this->specify('stores', function () use ($result) {
            $stores = $result->getStores();
            $firstStore = $stores[0];

            $this->assertCount(13, $stores);
            $this->assertEquals('Домодедовская таможня', $firstStore->getName());
        });
    }

}