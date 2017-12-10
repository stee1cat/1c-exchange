<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use Codeception\Test\Unit;
use Codeception\Util\Stub;
use stee1cat\CommerceMLExchange\EventDispatcher;

class Listener {
    public function onEvent() {}
}

/**
 * Class EventDispatcherTest
 */
class EventDispatcherTest extends Unit {

    /**
     * @var EventDispatcher
     */
    protected $tester;

    protected function _before() {
        $this->tester = new EventDispatcher();
    }

    public function testDispatch() {
        $listener = Stub::makeEmpty(Listener::class, [
            'onEvent' => Stub::once()
        ], $this);

        $this->tester->addListener('event.test', [$listener, 'onEvent']);
        $this->tester->dispatch('event.test');
    }

}