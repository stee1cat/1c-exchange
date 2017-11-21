<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

/**
 * Class ArchiveReader
 * @package stee1cat\CommerceMLExchange
 */
class ArchiveReader {

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $tempFolder;

    /**
     * ArchiveReader constructor.
     *
     * @param string $file
     * @param string $tempFolder
     */
    public function __construct($file, $tempFolder) {
        $this->file = $file;
        $this->tempFolder = $tempFolder;
    }

    public function open() {
        $this->openGroups();
    }

    protected function openGroups() {
        $files = glob($this->file . DIRECTORY_SEPARATOR . 'import_*.xml');
        if (count($files) > 0) {
            $data = file_get_contents($files[0]);
            $parser = new ClassifierXmlParser($data);

            echo '<pre>', print_r($parser->getStores(), 1), '</pre>';
            exit;
        }
    }

}