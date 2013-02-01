<?php

namespace SpeckCart\Entity;

use \DateTime;

class Cart implements CartInterface
{
    use LineItemCollectionTrait;

    /**
     * @var int
     */
    protected $cartId = 0;

    /**
     * @var DateTime
     */
    protected $createdTime;

    public function getCartId()
    {
        return $this->cartId;
    }

    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function setCreatedTime(DateTime $time)
    {
        $this->createdTime = $time;
        return $this;
    }
}
