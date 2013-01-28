<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\LineItemInterface;

class LineItemHierarchyBuilder
{
    protected $index;

    /**
     * Build hierarchy, using parent id,from provided list of line items
     *
     * @param mixed $lineItems iterable list of line items
     * @param LineItemInterface $dummyProto Can be provided to make dummy lines
     *                                      in case list is incomplete and some
     *                                      parents missing
     *
     * @todo add circular dependency detection !IMPORTANT!
     * @todo initial rewrite, needs refinement and refactoring
     *
     * @return array
     * @throws InvalidArgumentException
     * @throws RuntimeException If parent line missing and dummy was not provided
     */
    public function build($lineItems, LineItemInterface $dummyProto = null)
    {
        if (!(is_array($line) || $lineItems instanceof Traversable)) {
            throw new \InvalidArgumentException('$lineItems must be array or Traversable');
        }

        $index = array();
        $result = array();
        $postponed = array();
        $circullarIndex = array();

        //build index, set root lines to result, postpone action if parent is not yet in index
        foreach ($lineItems as $line) {
            if(!$item instanceof LineItemInterface) {
                throw new \InvalidArgumentException('Line item must be instance of LineItemInterface');
            }

            if ($line->getLineItemId()) {
                $this->index[$line->getLineItemId()] = $item;
            }

            $parentId = $line->getParentLineId();
            if (!$parentId) {
                $result[] = $item;
                continue;
            }

            if (isset($index[$parentId])) {
                $index[$parentId]->addLineItem($line);
            } else {
                $postponed[] = $line;
            }
        }

        foreach($postponed as $line) {
            $parentId = $line->getParentLineId();
            if (isset($index[$parentId])) {
                $index[$parentId]->addLineItem($line);
                continue;
            }

            if (!$dummyProto === null) {
                throw new \RuntimeException('Parent line with specified id not found');
            }

            $dummy = clone $dummyProto;
            $dummy->setLineItemId($parentId);
            $dummy->addLineItem($line);
            $index[$parentId] = $dummy;
            $result[] = $dummy;
        }

        return $result;
    }
}

