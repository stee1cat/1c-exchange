<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Product;
use stee1cat\CommerceMLExchange\Model\Property;

/**
 * Class ProductTest
 * @package Model
 */
class ProductTest extends Unit {

    use Specify;

    public function testCreate() {
        $product = $this->createProduct(<<<XML
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
    <Картинка>image.gif</Картинка>
    <ЗначенияРеквизитов>
        <ЗначениеРеквизита>
            <Наименование>property1</Наименование>
            <Значение>value1</Значение>
        </ЗначениеРеквизита>
        <ЗначениеРеквизита>
            <Наименование>property2</Наименование>
            <Значение>value2</Значение>
        </ЗначениеРеквизита>
    </ЗначенияРеквизитов>
</Товар>
XML
        );

        $this->specify('validate fields', function () use ($product) {
            $this->assertEquals('345c3985-4023-11e6-b3ae-00155d1f3004', $product->getId());
            $this->assertEquals('Product #1', $product->getName());
            $this->assertEquals('Description', $product->getDescription());
            $this->assertEquals('12345', $product->getVendorCode());
            $this->assertEquals('image.gif', $product->getImage());

            $this->assertCount(2, $product->getGroups());
            $this->assertContains('d731bdf4-fd2c-11e4-89fa-00155d1f3004', $product->getGroups());

            $this->assertCount(2, $product->getProperties());
            $this->assertContainsOnlyInstancesOf(Property::class, $product->getProperties());
        });
    }

    public function testGetProperty() {
        $product = $this->createProduct(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Товар>
    <Ид>345c3985-4023-11e6-b3ae-00155d1f3004</Ид>
    <Наименование>Product #1</Наименование>
    <Артикул>12345</Артикул>
    <ЗначенияРеквизитов>
        <ЗначениеРеквизита>
            <Наименование>property1</Наименование>
            <Значение>value1</Значение>
        </ЗначениеРеквизита>
        <ЗначениеРеквизита>
            <Наименование>property2</Наименование>
            <Значение>value2</Значение>
        </ЗначениеРеквизита>
    </ЗначенияРеквизитов>
</Товар>
XML
        );
        $property = $product->getProperty('property2');

        $this->assertInstanceOf(Property::class, $property);
        $this->assertEquals('property2', $property->getName());
        $this->assertEquals('value2', $property->getValue());
    }

    public function testMarkAsDelete() {
        $product1 = $this->createProduct(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Товар>
    <Ид>345c3985-4023-11e6-b3ae-00155d1f3004</Ид>
    <Наименование>product1</Наименование>
    <ПометкаУдаления>1</ПометкаУдаления>
</Товар>
XML
        );
        $this->assertEquals(true, $product1->isMarkAsDelete());

        $product2 = $this->createProduct(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Товар>
    <Ид>345c3985-4023-11e6-b3ae-00155d1f3004</Ид>
    <Наименование>product2</Наименование>
    <ПометкаУдаления>0</ПометкаУдаления>
</Товар>
XML
        );
        $this->assertEquals(false, $product2->isMarkAsDelete());

        $product3 = $this->createProduct(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Товар>
    <Ид>345c3985-4023-11e6-b3ae-00155d1f3004</Ид>
    <Наименование>product3</Наименование>
    <ПометкаУдаления>false</ПометкаУдаления>
</Товар>
XML
        );
        $this->assertEquals(false, $product3->isMarkAsDelete());

        $product4 = $this->createProduct(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Товар>
    <Ид>345c3985-4023-11e6-b3ae-00155d1f3004</Ид>
    <Наименование>product4</Наименование>
    <ПометкаУдаления>true</ПометкаУдаления>
</Товар>
XML
        );
        $this->assertEquals(true, $product4->isMarkAsDelete());
    }

    /**
     * @param string $string
     *
     * @return Product
     */
    protected function createProduct($string) {
        $xml = simplexml_load_string($string);
        return Product::create($xml);
    }

}