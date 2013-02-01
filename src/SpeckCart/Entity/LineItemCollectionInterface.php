<?php
namespace SpeckCart\Entity;

interface LineItemCollectionInterface
{
    public function addLineItem(LineItemInterface $item);

    public function addLineItems(array $items);

    public function removeLineItem($itemOrItemId);

    public function setLineItems(array $items);

    public function getLineItems();
}
