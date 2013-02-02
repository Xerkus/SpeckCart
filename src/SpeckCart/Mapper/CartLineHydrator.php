<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\Item;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CartLineHydrator extends LineItemHydrator
{
    protected $itemHydrator;

    public function __construct(HydratorInterface $itemHydrator = null)
    {
        if($itemHydrator === null) {
            $itemHydrator = new ItemHydrator;
        }
        $this->itemHydrator = $itemHydrator;
    }

    public function extract($object)
    {
        $result = parent::extract($object);
        $result['cart_id'] = $object->getCartId();
        $result['item_type'] = get_class($object->getItem());
        $result = array_merge($result, $this->itemHydrator->extract($object->getItem()));

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        parent::hydrate($data, $object);
        $object->setCartId($data['cart_id']);

        $item = $this->getItem($data['item_type']);
        $this->itemHydrator->hydrate($data, $item);
        $object->setItem($item);

        return $object;
    }

    public function getItem($class)
    {
        if(class_exists($class, true) && is_subclass_of($class, 'SpeckCart\\Entity\\ItemInterface')) {
            return new $class;
        }
        return new Item;
    }
}

