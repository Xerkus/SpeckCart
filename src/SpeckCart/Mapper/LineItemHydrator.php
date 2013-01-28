<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class LineItemHydrator implements HydratorInterface
{
    protected $lineIdField       = 'line_id';
    protected $priceField        = 'price';
    protected $quantityField     = 'quantity';
    protected $taxField          = 'tax';
    protected $addedTimeField    = 'added_time';
    protected $parentLineIdField = 'parent_line_id';

    public function extract($object)
    {
        $result = array(
            $this->priceField        => $object->getPrice() ?: 0.00,
            $this->quantityField     => $object->getQuantity() ?: 0,
            $this->taxField          => $object->getTax() ?: 0,
            $this->addedTimeField    => $object->getAddedTime()->format('c'),
            $this->parentLineIdField => $object->getParentLineId(),
        );

        if ($object->getLineItemId() !== null) {
            $result[$this->lineId] = $object->getLineItemId();
        }

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setLineItemId($data[$this->lineIdField])
            ->setPrice($data[$this->priceField])
            ->setQuantity($data[$this->quantityField])
            ->setTax($data[$this->taxField])
            ->setAddedTime(new \DateTime($data[$this->addedTimeField]))
            ->setParentLineId($data[$this->parentLineIdField]);

        return $object;
    }
}

