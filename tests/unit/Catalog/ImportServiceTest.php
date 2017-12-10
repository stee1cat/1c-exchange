<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Catalog;

use Codeception\Test\Unit;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use stee1cat\CommerceMLExchange\Catalog\ImportService;
use stee1cat\CommerceMLExchange\EventDispatcher;

/**
 * Class ImportServiceTest
 * @package Catalog
 */
class ImportServiceTest extends Unit {

    /**
     * @var ImportService
     */
    protected $tester;

    /**
     * @var vfsStreamDirectory
     */
    protected $root;

    protected function _before() {
        $this->tester = new ImportService(new EventDispatcher());
        $this->root = vfsStream::setup();
    }

    public function testLoadFile() {
        $content = 'import content';
        $filename = 'import.xml';

        $file = vfsStream::newFile($filename)
            ->withContent($content)
            ->at($this->root);

        $this->tester->load($file->url());

        $this->assertEquals($content, $this->tester->getContent());
    }

    public function testIsClassifier() {
        $content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ВерсияСхемы="3.1" ДатаФормирования="2017-12-07T10:00:00">
    <Классификатор СодержитТолькоИзменения="true">
        <Ид>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</Ид>
    </Классификатор>
    <Каталог СодержитТолькоИзменения="true">
        <Ид>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</Ид>
        <ИдКлассификатора>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</ИдКлассификатора>
        <Наименование>goods</Наименование>
        <Описание>goods</Описание>
    </Каталог>
</КоммерческаяИнформация>
XML;

        $xml = simplexml_load_string($content);

        $this->assertEquals(true, $this->tester->isClassifier($xml));
    }

    public function testIsCatalog() {
        $content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ВерсияСхемы="3.1" ДатаФормирования="2017-12-07T10:00:00">
	<Каталог СодержитТолькоИзменения="true">
		<Ид>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</Ид>
		<ИдКлассификатора>8d9f1f3f-d0d4-4f94-abe4-8e15257279bb</ИдКлассификатора>
		<Наименование>goods</Наименование>
	</Каталог>
</КоммерческаяИнформация>
XML;

        $xml = simplexml_load_string($content);

        $this->assertEquals(true, $this->tester->isCatalog($xml));
    }

}