<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Stock;

/**
 * Class StockTest
 * @package Model
 */
class StockTest extends Unit {

    use Specify;

    public function testCreate() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Склад>
    <Ид>9cd90bdf-6dd1-11e1-816d-525400123411</Ид>
    <Количество>33</Количество>
</Склад>
XML;
        $xml = simplexml_load_string($string);
        $stock = Stock::create($xml);

        $this->specify('validate fields', function () use ($stock) {
            $this->assertEquals(33, $stock->getQuantity(), 'quantity');
            $this->assertEquals('9cd90bdf-6dd1-11e1-816d-525400123411', $stock->getStoreId(), 'stock id');
        });
    }
}