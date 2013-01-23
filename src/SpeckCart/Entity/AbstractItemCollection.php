<?php
namespace SpeckCart\Entity;

use \IteratorAggregate;
use \ArrayIterator;
use \Countable;
use \InvalidArgumentException;

abstract class AbstractItemCollection implements LineItemCollectionInterface
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
        // ensure line with same id is replaced
        if (null != $item->getLineItemId()) {
            $this->removeLineItem($item->getLineItemId());
        }

        // inject this object as parent if it is line item
        if ($this instanceof LineItemInterface) {
            $item->setParent($this);
        }

        $this->lineItems[spl_object_hash($item)] = $item;
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
            //if line item have no id, just remove object
            if (!$item->getLineItemId()) {
                $hash = spl_object_hash($itemOrItemId);
                unset($this->lineItems[$hash]);
                return $this;
            }
            $itemOrItemId = $item->getLineItemId();
        }

        if (!(is_numeric($itemOrItemId) || is_string($itemOrItemId)) || empty($itemOrItemId)) {
            throw new InvalidArgumentException('Line item id must be non-empty numeric value or string');
        }

        // keep items whose ids are not equal to specified
        $this->lineItems = array_filter(
            $this->lineItems,
            function($lineItem) use ($itemOrItemId) {
                // use string comparison in case id is not numeric
                return (string)$lineItem->getLineItemId() !== (string)$itemOrItemId;
            }
        );
        return $this;
    }

    public function setLineItems(array $items)
    {
        $this->lineItems = array();
        $this->addLineItems($items);

        return $this;
    }

    public function getItems()
    {
        return $this->items;
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
