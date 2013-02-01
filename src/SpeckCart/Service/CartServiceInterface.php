<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\CartInterface;
use SpeckCart\Entity\CartLineInterface;

interface CartServiceInterface
{
    /**
     * Add an item to a cart
     *
     * @param CartLineInterface item to add
     * @param CartInterface cart to modify -- default to current session's cart if null
     * @return CartServiceInterface
     */
    public function addLineToCart(CartLineInterface $line, CartInterface $cart = null);

    /**
     * Remove an line item from a cart
     *
     * @param int ID of the cart lineitem to remove
     * @param CartInterface cart to remove from -- default to current session's cart if null
     * @return CartServiceInterface
     */
    public function removeLineFromCart($lineId, CartInterface $cart = null);
}
