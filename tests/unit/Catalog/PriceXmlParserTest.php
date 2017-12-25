<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Catalog;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Catalog\PriceXmlParser;
use stee1cat\CommerceMLExchange\Model\Offer;

class PriceXmlParserTest extends Unit {

    use Specify;

    /**
     * @var PriceXmlParser
     */
    protected $tester;

    protected function _before() {
        $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ВерсияСхемы="3.1" ДатаФормирования="2017-12-07T10:00:00">
	<ПакетПредложений СодержитТолькоИзменения="true">
		<Ид>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb#</Ид>
		<Наименование>offers</Наименование>
		<ИдКаталога>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</ИдКаталога>
		<ИдКлассификатора>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</ИдКлассификатора>
		<Предложения>
			<Предложение>
				<Ид>8969768b-d588-11e6-a864-00155d468008</Ид>
				<Цены>
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
			</Предложение>
			<Предложение>
				<Ид>8a1011a2-d70e-11e6-a864-00155d468008</Ид>
				<Цены>
					<Цена>
						<Представление>450 РУБ за пог. м</Представление>
						<ИдТипаЦены>3c9cbc64-d750-11e6-a864-00155d468008</ИдТипаЦены>
						<ЦенаЗаЕдиницу>450</ЦенаЗаЕдиницу>
						<Валюта>РУБ</Валюта>
						<Налог>
							<Наименование>НДС</Наименование>
							<УчтеноВСумме>true</УчтеноВСумме>
						</Налог>
					</Цена>
				</Цены>
			</Предложение>
        </Предложения>
    </ПакетПредложений>
</КоммерческаяИнформация>
XML;
        $xml = loadXmlString($string);

        $this->tester = new PriceXmlParser($xml);
    }

    public function testParse() {
        $result = $this->tester->parse();

        $this->specify('Offers', function () use ($result) {
            $offers = $result->getOffers();
            $firstOffer = reset($offers);

            $this->assertInstanceOf(Offer::class, $firstOffer);
            $this->assertCount(2, $offers);
        });
    }

}