<?php

namespace SpeckCart\Entity;

use DateTime;

abstract class AbstractLineItem implements LineItemInterface
{
    use LineItemCollectionTrait;

    protected $lineItemId;

    protected $parentLineId;

    protected $parentLine;

    protected $line;

    protected $price;

    protected $quantity;

    protected $addedTime;

    protected $tax;

    /**
     * Get the ID for this line item
     *
     * @return int
     */
    public function getLineItemId()
    {
        return $this->lineItemId;
    }

    /**
     * Set the ID for this line item
     *
     * @param int cartItemId
     * @return LineItemInterface
     */
    public function setLineItemId($lineItemId)
    {
        $this->lineItemId = $lineItemId;
        return $this;
    }

    /**
     * Returns parent line id. Proxies to parent entity if present.
     *
     * @return null|integer
     */
    public function getParentLineId()
    {
        if ($this->parentLine) {
            return $this->parentLine->getLineItemId();
        }
        return $this->parentLineId;
    }

    /**
     * Sets parent line id, if parent entity is not present.
     *
     * @param integer|null $id
     * @return LineItemInterface Provides fluent interface
     *
     * @throws RuntimeException If parent line entity is set
     */
    public function setParentLineId($id)
    {
        if ($id === null) {
            $this->parentLine = null;
        }

        if ($this->parentLine && $this->parentLine->getLineItemId() != $id) {
            throw new RuntimeException('Ambiguous assignment. Parent line entity is set and have different id.');
        }

        $this->parentLineId = $id;
        return $this;
    }

    /**
     * Get the parent entity
     *
     * @return LineItemInterface|null
     */
    public function getParentLine()
    {
        return $this->parentLine;
    }

    /**
     * setParent
     *
     * @param LineItemInterface $parent
     * @return LineItemInterface provides fluent interface
     */
    public function setParentLine(LineItemInterface $parent = null)
    {
        $this->parentLine = $parent;
        if ($parent === null) {
            $this->parentLineId = null;
        }
        return $this;
    }

    /**
     * Get item
     *
     * @return ItemInterface
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set item
     *
     * @param ItemInterface $item
     * @return LineItemInterface provides fluent interface
     */
    public function setItem(ItemInterface $item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * Get the price of this item
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the price of this item
     *
     * @param float price
     * @return LineItemInterface
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get the number of items in the cart
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the number of items in the cart
     *
     * @param int quantity
     * @return LineItemInterface
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Get the DateTime that this item was added to the cart
     *
     * @return DateTime
     */
    public function getAddedTime()
    {
        return $this->addedTime;
    }

    /**
     * Set the DateTime that this item was added to the cart
     *
     * @param DateTime added time
     * @return LineItemInterface
     */
    public function setAddedTime(DateTime $time)
    {
        $this->addedTime = $time;
        return $this;
    }

    /**
     * Get the tax associated for this item
     *
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set the tax associated for this item
     *
     * @return LineItemInterface
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * Get the extended amount for this line
     *
     * @return float
     */
    public function getExtAmount()
    {
        return $this->getPrice() * $this->getQuantity();
    }

    /**
    * Get the tax amount for this line
    *
    * @return float
    */
    public function getExtTaxAmount()
    {
        return $this->getTax() * $this->getQuantity();
    }

    /**
     * Get total line amount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->getExtAmount() + $this->getExtTaxAmount();
    }
}
