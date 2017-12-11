<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Catalog;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Catalog\CatalogXmlParser;
use stee1cat\CommerceMLExchange\Model\Product;

/**
 * Class CatalogXmlParserTest
 * @package Catalog
 */
class CatalogXmlParserTest extends Unit {

    use Specify;

    /**
     * @var CatalogXmlParser
     */
    protected $tester;

    protected function _before() {
        $content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ВерсияСхемы="3.1" ДатаФормирования="2017-12-07T10:00:00">
    <Каталог СодержитТолькоИзменения="true">
        <Ид>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</Ид>
        <Наименование>goods</Наименование>
        <Товары>
            <Товар>
                <Ид>345c3985-4023-11e6-b3ae-00155d1f3004</Ид>
                <Наименование>Product #1</Наименование>
            </Товар>
            <Товар>
                <Ид>def01183-40e0-11e6-b3ae-00155d1f3004</Ид>
                <Наименование>Product #2</Наименование>
            </Товар>
        </Товары>
    </Каталог>
</КоммерческаяИнформация>
XML;
        $xml = simplexml_load_string($content);

        $this->tester = new CatalogXmlParser($xml);
    }

    public function testParse() {
        $result = $this->tester->parse();

        $this->specify('Products', function () use ($result) {
            $products = $result->getProducts();
            $firstProduct = $products[0];

            $this->assertInstanceOf(Product::class, $firstProduct);
            $this->assertEquals(2, count($products));
        });
    }

}