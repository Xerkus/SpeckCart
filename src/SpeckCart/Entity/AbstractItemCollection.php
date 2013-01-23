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

    protected $lineItemsTmp = array();
    /**
     * constructor
     *
     * @param array items already in cart
     */
    public function __construct(array $items = array())
    {
        $this->setLineItems($items);
    }

    protected function reindexLineItems()
    {
        foreach ($this->lineItemsTmp as $key => $item) {
            if($item->getLineItemId()) {
                $this->lineItems[$item->getLineItemId()] = $item;
                unset($this->lineItemsTmp[$key]);
            }
        }
    }

    public function addLineItem(LineItemInterface $item)
    {
        // inject this object as parent if it is line item
        if ($this instanceof LineItemInterface) {
            $item->setParent($this);
        }

        // ensure line with same id is replaced
        if (null == $item->getLineItemId()) {
            $this->lineItemsTmp[spl_object_hash($item)] = $item;
            return $this;
        }

        $this->reindexLineItems();

        $this->lineItems[$item->getLineItemId()] = $item;
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
                unset($this->lineItemsTmp[$hash]);
                return $this;
            }
            $itemOrItemId = $item->getLineItemId();
        }

        $this->reindexLineItems();
        unset($this->lineItems[$itemOrItemId]);
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
        $this->reindexLineItems();
        return array_merge($this->lineItems, $this->lineItemsTmp);
    }

    /**
     * count
     *
     * @see Countable
     * @return integer
     */
    public function count()
    {
        return count($this->getLineItems());
    }

    /**
     * getIterator
     *
     * @see IteratorAggregate
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getLineItems());
    }
}
