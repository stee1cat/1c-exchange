<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Product;

/**
 * Class ProductTest
 * @package Model
 */
class ProductTest extends Unit {

    use Specify;

    public function testCreate() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Товар>
    <Ид>345c3985-4023-11e6-b3ae-00155d1f3004</Ид>
    <Наименование>Product #1</Наименование>
    <Артикул>12345</Артикул>
    <Группы>
        <Ид>08d324d2-14f0-11e6-87a4-00155d1f3004</Ид>
        <Ид>d731bdf4-fd2c-11e4-89fa-00155d1f3004</Ид>
    </Группы>
    <Описание>
        Description
    </Описание>
</Товар>
XML;
        $xml = simplexml_load_string($string);
        $product = Product::create($xml);

        $this->specify('validate fields', function () use ($product) {
            $this->assertEquals('345c3985-4023-11e6-b3ae-00155d1f3004', $product->getId());
            $this->assertEquals('Product #1', $product->getName());
            $this->assertEquals('Description', $product->getDescription());
            $this->assertEquals('12345', $product->getVendorCode());
            $this->assertEquals(1, array_search('d731bdf4-fd2c-11e4-89fa-00155d1f3004', $product->getGroups()));
        });
    }
}