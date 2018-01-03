<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Property;

/**
 * Class PropertyTest
 * @package Model
 */
class PropertyTest extends Unit {

    use Specify;

    public function testCreate() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<ЗначениеРеквизита>
    <Наименование>property</Наименование>
    <Значение>100</Значение>
</ЗначениеРеквизита>
XML;
        $xml = simplexml_load_string($string);
        $property = Property::create($xml);

        $this->specify('validate fields', function () use ($property) {
            $this->assertEquals('property', $property->getName());
            $this->assertEquals('100', $property->getValue());
        });
    }

}