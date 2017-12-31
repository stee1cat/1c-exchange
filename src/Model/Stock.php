<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Stock
 * @package stee1cat\CommerceMLExchange\Model
 */
class Stock {

    /**
     * @var string
     */
    protected $storeId;

    /**
     * @var float
     */
    protected $quantity;

    public static function create(\SimpleXMLElement $element) {
        $stock = new self();

        if ($id = $element->xpath('./Ид')) {
            $stock->setStoreId((string) $id[0]);
        }

        if ($quantity = $element->xpath('./Количество')) {
            $stock->setQuantity((float) $quantity[0]);
        }

        return $stock;
    }

    /**
     * @return string
     */
    public function getStoreId() {
        return $this->storeId;
    }

    /**
     * @param string $storeId
     *
     * @return Stock
     */
    public function setStoreId($storeId) {
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     *
     * @return Stock
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

}