<?php
namespace SpeckCart\Entity;

use \Iterator;
use \Countable;

interface LineItemCollectionInterface extends Iterator, Countable
{
    public function addLineItem(LineItemInterface $item);

    public function addLineItems(array $items);

    public function removeLineItem($itemOrItemId);

    public function setLineItems(array $items);

    public function getLineItems();
}
