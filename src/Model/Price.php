<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange\Model;

/**
 * Class Price
 * @package stee1cat\CommerceMLExchange\Model
 */
class Price {

    /**
     * @var float
     */
    protected $value;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $typeId;

    public static function create(\SimpleXMLElement $element) {
        $price = new self();

        if ($value = $element->xpath('./ЦенаЗаЕдиницу')) {
            $price->setValue((float) $value[0]);
        }

        if ($currency = $element->xpath('./Валюта')) {
            $price->setCurrency((string) $currency[0]);
        }

        if ($typeId = $element->xpath('./ИдТипаЦены')) {
            $price->setTypeId((string) $typeId[0]);
        }

        return $price;
    }

    /**
     * @return float
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param float $value
     *
     * @return Price
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Price
     */
    public function setCurrency($currency) {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeId() {
        return $this->typeId;
    }

    /**
     * @param string $typeId
     *
     * @return Price
     */
    public function setTypeId($typeId) {
        $this->typeId = $typeId;

        return $this;
    }

}