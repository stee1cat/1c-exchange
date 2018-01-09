<?php
/**
 * Copyright (c) 2018 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Validator;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Validator\FilenameValidator;

/**
 * Class FilenameValidatorTest
 * @package Validator
 */
class FilenameValidatorTest extends Unit {

    use Specify;

    public function testValidateImport() {
        $validator = new FilenameValidator('import___c91d43c6-ea56-4fb3-821b-2973d6666086.xml');

        $this->assertTrue($validator->validate());
    }

    public function testValidateReport() {
        $this->specify('correct report filename', function () {
            $validator = new FilenameValidator('Exchange_(shop.local)2018-01-09.zip');

            $this->assertTrue($validator->validate());
        });

        $this->specify('incorrect report filename', function () {
            $validator = new FilenameValidator('../../Exchange_(shop.local)2018-01-09.zip');

            $this->assertFalse($validator->validate());
        });
    }

}