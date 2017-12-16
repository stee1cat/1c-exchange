<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

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
        $request = new Request($this->makeEnvironment());

        $this->specify('Request with correct uri', function () use ($request) {
            $this->assertEquals('catalog', $request->get('type'));
            $this->assertEquals('default', $request->get('unknown_key', 'default'));
            $this->assertEquals(null, $request->get('unknown_key'));
        });
    }

    public function testGetUri() {
        $request = new Request($this->makeEnvironment());

        $this->assertEquals(self::CORRECT_URI, $request->getUri());
    }

    public function testGetMethod() {
        $request = new Request($this->makeEnvironment());

        $this->assertEquals('GET', $request->getMethod());
    }

    public function testGetAuthData() {
        $this->specify('Request with authorization', function () {
            $environment = $this->makeEnvironment();

            $environment['PHP_AUTH_USER'] = 'admin';
            $environment['PHP_AUTH_PW'] = 'qwerty';

            $request = new Request($environment);
            $authData = $request->getAuthData();

            $this->assertEquals('admin', $authData->getUsername());
            $this->assertEquals('qwerty', $authData->getPassword());
        });

        $this->specify('Request without authorization', function () {
            $environment = $this->makeEnvironment();

            $request = new Request($environment);
            $authData = $request->getAuthData();

            $this->assertEquals('', $authData->getUsername());
            $this->assertEquals('', $authData->getPassword());
        });
    }

    public function testGetAuthDataCgi() {
        $variables = ['REMOTE_USER', 'REDIRECT_REMOTE_USER', 'HTTP_AUTHORIZATION', 'REDIRECT_HTTP_AUTHORIZATION'];

        foreach ($variables as $variable) {
            $this->specify("Request with '$variable' variable", function () use ($variable) {
                $environment = $this->makeEnvironment();

                $environment[$variable] = $this->generateAuthorizationHeader('admin', 'qwerty');

                $request = new Request($environment);
                $authData = $request->getAuthData();

                $this->assertEquals('admin', $authData->getUsername());
                $this->assertEquals('qwerty', $authData->getPassword());
            });
        }
    }

    protected function generateAuthorizationHeader($user, $password) {
        return 'Basic ' . base64_encode($user . ':' . $password);
    }

    /**
     * @return string[]
     */
    protected function makeEnvironment() {
        return [
            'REQUEST_URI' => self::CORRECT_URI,
            'REQUEST_METHOD' => 'GET',
        ];
    }

}