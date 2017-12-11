<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Model\Group;
use stee1cat\CommerceMLExchange\Model\Product;
use stee1cat\CommerceMLExchange\Model\Store;

/**
 * Class Result
 * @package stee1cat\CommerceMLExchange\Catalog
 */
class Result {

    /**
     * @var Product[]
     */
    protected $products = [];

    /**
     * @var Store[]
     */
    protected $stores = [];

    /**
     * @var Group[]
     */
    protected $groups = [];

    /**
     * @return Product[]
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * @param Product[] $products
     *
     * @return Result
     */
    public function setProducts($products) {
        $this->products = $products;

        return $this;
    }

    /**
     * @return Store[]
     */
    public function getStores() {
        return $this->stores;
    }

    /**
     * @param Store[] $stores
     *
     * @return Result
     */
    public function setStores($stores) {
        $this->stores = $stores;

        return $this;
    }

    /**
     * @return Group[]
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * @param Group[] $groups
     *
     * @return Result
     */
    public function setGroups($groups) {
        $this->groups = $groups;

        return $this;
    }

}