<?php

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Http\Request;

/**
 * Class RequestTest
 */
class RequestTest extends Unit {

    use Specify;

    const CORRECT_URI = '/1c-exchange?type=catalog&mode=checkauth';

    public function testGet() {
        $request = new Request($this->makeCorrectRequest());

        $this->specify('Request with correct uri', function () use ($request) {
            $this->assertEquals('catalog', $request->get('type'));
            $this->assertEquals('default', $request->get('unknown_key', 'default'));
            $this->assertEquals(null, $request->get('unknown_key'));
        });
    }

    public function testGetUri() {
        $request = new Request($this->makeCorrectRequest());

        $this->assertEquals(self::CORRECT_URI, $request->getUri());
    }

    public function testGetMethod() {
        $request = new Request($this->makeCorrectRequest());

        $this->assertEquals('GET', $request->getMethod());
    }

    /**
     * @return string[]
     */
    protected function makeCorrectRequest() {
        return [
            'REQUEST_URI' => self::CORRECT_URI,
            'REQUEST_METHOD' => 'GET',
        ];
    }

}