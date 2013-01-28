<?php

namespace SpeckCart\Entity;

use DateTime;

class CartLine extends AbstractLineItem implements CartLineInterface
{
    protected $cartId;
    protected $tax = 0;
    protected $parentItemId = 0;
    protected $metadata;

    public function getCartId()
    {
        return $this->cartId;
    }

    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }

    public function getPrice($recursive = false)
    {
        if (false === $recursive) {
            return $this->price;
        }

        $price = $this->price;
        if (count($this) > 0) {
            foreach ($this as $item) {
                $price = $price + $item->getPrice(true);
            }
        }
        return $price;
    }

    public function removeLineItem($itemOrItemId)
    {
        throw new \Exception("not implemented");
    }

}
