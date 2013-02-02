<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class LineItemHydrator implements HydratorInterface
{
    public function extract($object)
    {
        $result = array(
            'price'          => $object->getPrice() ?: 0.00,
            'quantity'       => $object->getQuantity() ?: 0,
            'tax'            => $object->getTax() ?: 0,
            'parent_line_id' => $object->getParentLineId(),
        );

        if ($object->getLineItemId() !== null) {
            $result['line_id'] = $object->getLineItemId();
        }

        if ($object->getAddedTime() !== null) {
            $result['added_time'] = $object->getAddedTime()->format('c');

        }

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        if (isset($data['line_id'])) {
            $object->setLineItemId($data['line_id']);
        }
        if (isset($data['added_time'])) {
            $object->setAddedTime(new \DateTime($data['added_time']));
        }
        $object->setPrice($data['price'])
            ->setQuantity($data['quantity'])
            ->setTax($data['tax'])
            ->setParentLineId($data['parent_line_id']);

        return $object;
    }
}

