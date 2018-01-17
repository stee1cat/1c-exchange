<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Catalog;

use stee1cat\CommerceMLExchange\Model\Group;
use stee1cat\CommerceMLExchange\Model\Metadata;
use stee1cat\CommerceMLExchange\Model\Offer;
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
     * @var Offer[]
     */
    protected $offers = [];

    /**
     * @var Metadata
     */
    protected $metadata;

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

    /**
     * @return Offer[]
     */
    public function getOffers() {
        return $this->offers;
    }

    /**
     * @param Offer[] $offers
     *
     * @return Result
     */
    public function setOffers($offers) {
        $this->offers = $offers;

        return $this;
    }

    /**
     * @param Metadata $metadata
     */
    public function setMetadata(Metadata $metadata) {
        $this->metadata = $metadata;
    }

    /**
     * @return Metadata|null
     */
    public function getMetadata() {
        return $this->metadata;
    }

}