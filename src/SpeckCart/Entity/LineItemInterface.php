<?php

namespace SpeckCart\Entity;

use DateTime;

interface LineItemInterface extends LineItemCollectionInterface
{
    /**
     * Get the ID for this line item
     *
     * @return int
     */
    public function getLineItemId();

    /**
     * Set the ID for this line item
     *
     * @param int cartItemId
     * @return LineItemInterface
     */
    public function setLineItemId($lineItemId);

    /**
     * Returns parent line id. Proxies to parent entity if present.
     *
     * @return null|integer
     */
    public function getParentId();

    /**
     * Sets parent line id, if parent entity is not present.
     *
     * @param integer|null $id
     * @return LineItemInterface Provides fluent interface
     *
     * @throws RuntimeException If parent line entity is set
     */
    public function setParentId($id);

    /**
     * Get the parent entity
     *
     * @return LineItemInterface|null
     */
    public function getParent();

    /**
     * setParent
     *
     * @param LineItemInterface $parent
     * @return LineItemInterface provides fluent interface
     */
    public function setParent(LineItemInterface $parent = null);

    /**
     * Get item
     *
     * @return ItemInterface
     */
    public function getItem();

    /**
     * Set item
     *
     * @param ItemInterface $item
     * @return LineItemInterface provides fluent interface
     */
    public function setItem(ItemInterface $item);

    /**
     * Get the price of this item
     *
     * @return float
     */
    public function getPrice();

    /**
     * Set the price of this item
     *
     * @param float price
     * @return LineItemInterface
     */
    public function setPrice($price);

    /**
     * Get the number of items in the cart
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Set the number of items in the cart
     *
     * @param int quantity
     * @return LineItemInterface
     */
    public function setQuantity($quantity);

    /**
     * Get the DateTime that this item was added to the cart
     *
     * @return DateTime
     */
    public function getAddedTime();

    /**
     * Set the DateTime that this item was added to the cart
     *
     * @param DateTime added time
     * @return LineItemInterface
     */
    public function setAddedTime(DateTime $time);

    /**
     * Get the extended price for this item
     *
     * @return float
     */
    public function getExtensionAmount();

    /**
    * Get the tax associated for this item
    *
    * @return float
    */
    public function getTotalTaxAmount();

    /**
     * get total line amount
     *
     * @return void
     */
    public function getTotalAmount();
}
