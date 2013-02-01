<?php

namespace SpeckCart\Entity;

use DateTime;
use IteratorAggregate;
use Countable;

interface CartLineInterface extends LineItemInterface, IteratorAggregate, Countable
{
    /**
     * Get the cart ID this item belongs to
     *
     * @return int
     */
    public function getCartId();

    /**
     * Set the cart ID this item belongs to
     *
     * @param int cartId
     * @return CartItemInterface
     */
    public function setCartId($cartId);
}
