<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Metadata;

/**
 * Class MetadataTest
 * @package Model
 */
class MetadataTest extends Unit {

    use Specify;

    public function testCreate() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ВерсияСхемы="3.1" ДатаФормирования="2017-11-22T01:24:40" Ид="1">
    <Классификатор СодержитТолькоИзменения="true">
    </Классификатор>
</КоммерческаяИнформация>
XML;
        $xml = loadXmlString($string);
        $metadata = Metadata::create($xml);

        $this->specify('validate fields', function () use ($metadata) {
            $this->assertEquals('3.1', $metadata->getVersion());
            $this->assertEquals('2017-11-22T01:24:40', $metadata->getDate());
        });
    }

}