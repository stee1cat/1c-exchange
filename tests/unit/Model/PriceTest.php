<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Price;

/**
 * Class PriceTest
 * @package Model
 */
class PriceTest extends Unit {

    use Specify;

    public function testCreate() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Цена>
    <Представление>123,32 РУБ за шт</Представление>
    <ИдТипаЦены>9855a402-684f-11e1-94ce-525400123411</ИдТипаЦены>
    <ЦенаЗаЕдиницу>123.32</ЦенаЗаЕдиницу>
    <Валюта>RUB</Валюта>
    <Налог>
        <Наименование>НДС</Наименование>
        <УчтеноВСумме>true</УчтеноВСумме>
    </Налог>
</Цена>
XML;
        $xml = simplexml_load_string($string);
        $price = Price::create($xml);

        $this->specify('validate fields', function () use ($price) {
            $this->assertEquals(123.32, $price->getValue(), 'value');
            $this->assertEquals('RUB', $price->getCurrency(), 'currency');
            $this->assertEquals('9855a402-684f-11e1-94ce-525400123411', $price->getTypeId(), 'type id');
        });
    }

}