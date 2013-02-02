<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class ItemHydrator implements HydratorInterface
{
    public function extract($object)
    {
        $result = array(
            'item_name'        => $object->getName(),
            'item_description' => $object->getDescription(),
            'item_metadata'    => serialize($object->getMetadata()),
        );

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setName($data['item_name'])
            ->setDescription($data['item_description'])
            ->setMetadata(unserialize($data['item_metadata']));

        return $object;
    }
}

