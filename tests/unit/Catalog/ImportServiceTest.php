<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Catalog;

use Codeception\Specify;
use Codeception\Test\Unit;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use stee1cat\CommerceMLExchange\Catalog\ImportService;

/**
 * Class ImportServiceTest
 * @package Catalog
 */
class ImportServiceTest extends Unit {

    use Specify;

    /**
     * @var ImportService
     */
    protected $tester;

    /**
     * @var vfsStreamDirectory
     */
    protected $root;

    protected function _before() {
        $this->tester = new ImportService();
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

    public function testParseImportXml() {
        $filename = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'import___29d3f7f0-36dd-4eea-a06c-4c325bed4285.xml';
        $content = file_get_contents($filename);
        $this->tester->parse($content);

        $this->specify('Groups', function () {
            $groups = $this->tester->getGroups();
            $firstGroup = $groups[0];

            $this->assertEquals(1, count($groups));
            $this->assertEquals(11, count($firstGroup->getGroups()));
        });

        $this->specify('Stores', function () {
            $stores = $this->tester->getStores();
            $firstStore = $stores[0];

            $this->assertEquals(13, count($stores));
            $this->assertEquals('Домодедовская таможня', $firstStore->getName());
        });
    }

}