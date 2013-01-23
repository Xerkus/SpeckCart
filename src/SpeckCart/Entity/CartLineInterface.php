<?php

namespace SpeckCart\Entity;

use DateTime;

interface CartLineInterface extends LineItemInterface
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

    public function setTotalTaxAmount($tax);
}
