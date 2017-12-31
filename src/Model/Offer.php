<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Offer
 * @package stee1cat\CommerceMLExchange\Model
 */
class Offer {

    /**
     * @var string
     */
    protected $productId;

    /**
     * @var Price[]
     */
    protected $prices = [];

    /**
     * @var Stock[]
     */
    protected $stockAvailability = [];

    /**
     * @param \SimpleXMLElement $element
     *
     * @return Offer
     */
    public static function create(\SimpleXMLElement $element) {
        $offer = new self();

        if ($productId = $element->xpath('./Ид')) {
            $offer->setProductId((string) $productId[0]);
        }

        if ($data = $element->xpath('./Цены/Цена')) {
            foreach ($data as $item) {
                $price = Price::create($item);

                $offer->addPrice($price);
            }
        }

        if ($data = $element->xpath('./Остатки/Остаток/Склад')) {
            foreach ($data as $item) {
                $stock = Stock::create($item);

                $offer->addStockAvailability($stock);
            }
        }

        return $offer;
    }

    /**
     * @param Price $price
     *
     * @return $this
     */
    public function addPrice(Price $price) {
        $this->prices[$price->getTypeId()] = $price;

        return $this;
    }

    /**
     * @return Price[]
     */
    public function getPrices() {
        return $this->prices;
    }

    /**
     * @param Stock $stock
     *
     * @return $this
     */
    public function addStockAvailability(Stock $stock) {
        $this->stockAvailability[$stock->getStoreId()] = $stock;

        return $this;
    }

    /**
     * @return Stock[]
     */
    public function getStockAvailability() {
        return $this->stockAvailability;
    }

    /**
     * @return string
     */
    public function getProductId() {
        return $this->productId;
    }

    /**
     * @param string $productId
     *
     * @return Offer
     */
    public function setProductId($productId) {
        $this->productId = $productId;

        return $this;
    }

}