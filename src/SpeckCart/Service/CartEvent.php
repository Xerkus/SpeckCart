<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\CartLineInterface;

use Zend\EventManager\Event;

class CartEvent extends Event
{
    const EVENT_ADD_LINE         = 'addLine';
    const EVENT_ADD_LINE_POST    = 'addLine.post';
    const EVENT_REMOVE_LINE      = 'removeLine';
    const EVENT_REMOVE_LINE_POST = 'removeLine.post';

    public function setCartLine(CartLineInterface $cartItem)
    {
        $this->setParam('cartline', $cartItem);
        return $this;
    }

    public function getCartLine()
    {
        return $this->getParam('cartline');
    }
}
