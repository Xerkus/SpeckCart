<?php
namespace SpeckCart\Entity;

use \Iterator;
use \Countable;

abstract class AbstractItemCollection implements LineItemCollectionInterface
{
    /**
     * @var array
     */
    protected $items = array();

    /**
     * @var object
     */
    protected $parent = null;

    /**
     * constructor
     *
     * @param array items already in cart
     */
    public function __construct(array $items = array())
    {
        $this->setItems($items);
    }

    public function addLineItem(LineItemInterface $item)
    {
        if ($item->getLineItemId() == null) {
            $this->items[] = $item;
        } else {
            $this->items[$item->getLineItemId()] = $item;
        }
        return $this;
    }

    public function addLineItems(array $items)
    {
        foreach ($items as $i) {
            if ($i->getLineItemId() == null) {
                $this->items[] = $i;
            } else {
                $this->items[$i->getLineItemId()] = $i;
            }
        }

        return $this;
    }

    public function removeLineItem($itemOrItemId)
    {
        if ($itemOrItemId instanceof LineItemInterface) {
            $itemOrItemId = $itemOrItemId->getLineItemId();
        }
        if (isset($this->items[$itemOrItemId])) {
            unset($this->items[$itemOrItemId]);
        }

        return $this;
    }

    public function setLineItems(array $items)
    {
        $this->items = array();
        $this->addItems($items);

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }

    public function current()
    {
        return current($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function next()
    {
        next($this->items);
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function valid()
    {
        return current($this->items) !== false;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}
