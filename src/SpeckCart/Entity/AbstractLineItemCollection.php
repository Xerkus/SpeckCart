<?php
namespace SpeckCart\Entity;

use \IteratorAggregate;
use \ArrayIterator;
use \Countable;
use \InvalidArgumentException;

abstract class AbstractLineItemCollection implements LineItemCollectionInterface
{
    /**
     * @var array
     */
    protected $lineItems = array();

    /**
     * constructor
     *
     * @param array items already in cart
     */
    public function __construct(array $items = array())
    {
        $this->setLineItems($items);
    }

    public function addLineItem(LineItemInterface $item)
    {
        // inject this object as parent if it is line item
        if ($this instanceof LineItemInterface) {
            $item->setParent($this);
        }

        $hash = spl_object_hash($item);
        // if item is in collection, do nothing
        if (isset($this->lineItems[$hash])) {
            return $this;
        }

        // if item have id, remove any other instance with same id to ensure uniqueness
        if ($item->getLineItemId()) {
            $this->findAndRemoveLineItem($item->getLineItemId());
        }

        $this->lineItems[$hash] = $item;
        return $this;
    }

    public function addLineItems(array $items)
    {
        foreach ($items as $item) {
            $this->addLineItem($item);
        }

        return $this;
    }

    public function removeLineItem($itemOrItemId)
    {
        if ($itemOrItemId instanceof LineItemInterface) {
            if (!$itemOrItemId->getLineItemId()) {
                unset($this->lineItems[spl_object_hash($item)]);
                return $this;
            }
            $itemOrItemId = $itemOrItemId->getLineItemId();
        } elseif (empty($itemOrItemId)) {
            throw new InvalidArgumentException('Lineitem id parameter can not be empty');
        }

        foreach($this->lineItems as $key => $item) {
            if($item == $itemOrItemId) {
                unset($this->lineItems[$key]);
            }
        }
        return $this;
    }

    public function setLineItems(array $items)
    {
        $this->lineItems = array();
        $this->addLineItems($items);

        return $this;
    }

    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * count
     *
     * @see Countable
     * @return integer
     */
    public function count()
    {
        return count($this->lineItems);
    }

    /**
     * getIterator
     *
     * @see IteratorAggregate
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->lineItems);
    }
}
