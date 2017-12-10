<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Event;

/**
 * Class Event
 * @package stee1cat\CommerceMLExchange\Event
 */
class Event {

    protected $data;

    public function __construct($data = []) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

}