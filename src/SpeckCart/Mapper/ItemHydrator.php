<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class ItemHydrator implements HydratorInterface
{
    protected $nameField        = 'item_name';
    protected $descriptionField = 'item_description';
    protected $metadataField    = 'metadata';

    public function extract($object)
    {
        $result = array(
            $this->nameField     => $object->getName(),
            $this->descriptionField  => $object->getDescription(),
            $this->metadataField     => serialize($object->getMetadata()),
        );

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setName($data[$this->nameField])
            ->setDescription($data[$this->descriptionField])
            ->setMetadata(unserialize($data[$this->metadataField]));

        return $object;
    }
}

