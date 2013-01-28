<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class CartLineHydrator extends LineItemHydrator
{
    protected $cartIdField = 'cart_id';

    public function extract($object)
    {
        $result = parent::extract($object);
        $result[$this->cartIdField] = $object->getCartId();

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        parent::hydrate($data, $object);
        $object->setCartId($data[$this->cartIdField]);

        return $object;
    }
}

