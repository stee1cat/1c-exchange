<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

use stee1cat\CommerceMLExchange\Event\Event;

/**
 * Class EventDispatcher
 * @package stee1cat\CommerceMLExchange
 */
class EventDispatcher {

    /**
     * @var callable[][]
     */
    protected $listeners;

    /**
     * @param string $eventName
     * @param callable $callback
     */
    public function addListener($eventName, $callback) {
        if (!is_array($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = $callback;
    }

    /**
     * @param string $eventName
     * @param null|Event $event
     */
    public function dispatch($eventName, $event = null) {
        if ($event === null) {
            $event = new Event();
        }

        if (isset($this->listeners[$eventName])) {
            $events = $this->listeners[$eventName];

            foreach ($events as $eventName => $listener) {
                if (is_callable($listener)) {
                    $listener($event);
                }
            }
        }
    }

}