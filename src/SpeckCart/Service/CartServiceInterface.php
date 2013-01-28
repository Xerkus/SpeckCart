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
    public function addItemToCart(CartLineInterface $item, CartInterface $cart = null);

    /**
     * Remove an item from a cart
     *
     * @param int cart item ID of item to remove
     * @param CartInterface cart to remove from -- default to current session's cart if null
     * @return CartServiceInterface
     */
    public function removeItemFromCart($itemId, CartInterface $cart = null);
}
