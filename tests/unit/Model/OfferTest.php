<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Offer;
use stee1cat\CommerceMLExchange\Model\Price;
use stee1cat\CommerceMLExchange\Model\Stock;

/**
 * Class OfferTest
 * @package Model
 */
class OfferTest extends Unit {

    use Specify;

    public function testCreate() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Предложение>
    <Ид>8969768b-d588-11e6-a864-00155d468008</Ид>
    <Цены>
        <Цена>
            <Представление>258,972 РУБ за шт</Представление>
            <ИдТипаЦены>84da6ca5-d8bf-11e6-a864-00155d468008</ИдТипаЦены>
            <ЦенаЗаЕдиницу>258.97</ЦенаЗаЕдиницу>
            <Валюта>РУБ</Валюта>
            <Налог>
                <Наименование>НДС</Наименование>
                <УчтеноВСумме>true</УчтеноВСумме>
            </Налог>
        </Цена>
        <Цена>
            <Представление>222 РУБ за шт</Представление>
            <ИдТипаЦены>9855a402-684f-11e1-94ce-525400123411</ИдТипаЦены>
            <ЦенаЗаЕдиницу>222</ЦенаЗаЕдиницу>
            <Валюта>РУБ</Валюта>
            <Налог>
                <Наименование>НДС</Наименование>
                <УчтеноВСумме>true</УчтеноВСумме>
            </Налог>
        </Цена>
        <Цена>
            <Представление>123,32 РУБ за шт</Представление>
            <ИдТипаЦены>0ddbf8be-44fb-11e1-bf35-00804850163d</ИдТипаЦены>
            <ЦенаЗаЕдиницу>123.32</ЦенаЗаЕдиницу>
            <Валюта>РУБ</Валюта>
            <Налог>
                <Наименование>НДС</Наименование>
                <УчтеноВСумме>true</УчтеноВСумме>
            </Налог>
        </Цена>
        <Цена>
            <Представление>160,316 РУБ за шт</Представление>
            <ИдТипаЦены>3c9cbc64-d750-11e6-a864-00155d468008</ИдТипаЦены>
            <ЦенаЗаЕдиницу>160.32</ЦенаЗаЕдиницу>
            <Валюта>РУБ</Валюта>
            <Налог>
                <Наименование>НДС</Наименование>
                <УчтеноВСумме>false</УчтеноВСумме>
            </Налог>
        </Цена>
    </Цены>
    <Остатки>
        <Остаток>
            <Склад>
                <Ид>9cd90bdf-6dd1-11e1-816d-525400123411</Ид>
                <Количество>33</Количество>
            </Склад>
        </Остаток>
        <Остаток>
            <Склад>
                <Ид>9cd90be0-6dd1-11e1-816d-525400123411</Ид>
                <Количество>10</Количество>
            </Склад>
        </Остаток>
        <Остаток>
            <Склад>
                <Ид>9cd90be1-6dd1-11e1-816d-525400123411</Ид>
                <Количество>0</Количество>
            </Склад>
        </Остаток>
    </Остатки>
</Предложение>
XML;
        $xml = simplexml_load_string($string);
        $offer = Offer::create($xml);

        $this->specify('validate fields', function () use ($offer) {
            $this->assertEquals('8969768b-d588-11e6-a864-00155d468008', $offer->getProductId());

            $this->assertCount(4, $offer->getPrices());
            $this->assertContainsOnlyInstancesOf(Price::class, $offer->getPrices());

            $this->assertCount(3, $offer->getStockAvailability());
            $this->assertContainsOnlyInstancesOf(Stock::class, $offer->getStockAvailability());
        });
    }

    public function testAddPrice() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Предложение>
    <Ид>8969768b-d588-11e6-a864-00155d468008</Ид>
    <Цены>
        <Цена>
            <Представление>258,972 РУБ за шт</Представление>
            <ИдТипаЦены>84da6ca5-d8bf-11e6-a864-00155d468008</ИдТипаЦены>
            <ЦенаЗаЕдиницу>258.97</ЦенаЗаЕдиницу>
            <Валюта>РУБ</Валюта>
            <Налог>
                <Наименование>НДС</Наименование>
                <УчтеноВСумме>true</УчтеноВСумме>
            </Налог>
        </Цена>
    </Цены>
</Предложение>
XML;
        $xml = simplexml_load_string($string);
        $offer = Offer::create($xml);

        $price = new Price();
        $price->setValue(10)
            ->setCurrency('RUB');

        $this->assertCount(1, $offer->getPrices(), 'before add');

        $offer->addPrice($price);

        $this->assertCount(2, $offer->getPrices(), 'after add');
        $this->assertContainsOnlyInstancesOf(Price::class, $offer->getPrices());
    }

    public function testAddStockAvailability() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Предложение>
    <Ид>8969768b-d588-11e6-a864-00155d468008</Ид>
    <Остатки>
        <Остаток>
            <Склад>
                <Ид>9cd90bdf-6dd1-11e1-816d-525400123411</Ид>
                <Количество>33</Количество>
            </Склад>
        </Остаток>
    </Остатки>
</Предложение>
XML;
        $xml = simplexml_load_string($string);
        $offer = Offer::create($xml);

        $stock = new Stock();
        $stock->setStoreId('9cd90be1-6dd1-11e1-816d-525400123411')
            ->setQuantity(2);

        $this->assertCount(1, $offer->getStockAvailability(), 'before add');

        $offer->addStockAvailability($stock);

        $this->assertCount(2, $offer->getStockAvailability(), 'after add');
        $this->assertContainsOnlyInstancesOf(Stock::class, $offer->getStockAvailability());
    }

}