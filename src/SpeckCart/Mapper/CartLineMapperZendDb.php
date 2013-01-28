<?php

namespace SpeckCart\Mapper;

use ArrayObject;

use SpeckCart\Entity\CartLine;
use SpeckCart\Entity\CartLineInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ArraySerializable;

use ZfcBase\Mapper\AbstractDbMapper;

class CartLineMapperZendDb extends AbstractDbMapper implements CartLineMapperInterface
{
    protected $tableName = 'cart_lineitem';
    protected $itemIdField = 'line_id';
    protected $lineHierarchyBuilder;

    public function __construct()
    {
        $this->setEntityPrototype(new CartLine);
        $this->setHydrator(new CartLineHydrator);
    }

    public function findById($itemId)
    {
        $select = $this->getSelect();

        $where = new Where;
        $where->equalTo($this->itemIdField, $itemId);

        $resultSet = $this->select($select->where($where));
        return $resultSet->current();
    }

    /**
     * findByCartId
     *
     * @param int $cartId
     * @return array of LineItemInterface
     */
    public function findByCartId($cartId)
    {
        $where = new Where;
        $where->equalTo('cart_id', $cartId);

        $select = $this->getSelect();
        $select->order('parent_line_id ASC')
            ->where($where);

        $resultSet = $this->select($select);

        $hierarchyBuilder = $this->getLineHierarchyBuilder();
        $resultSet = $hierarchyBuilder->build($resultSet);

        return $resultSet;
    }

    public function deleteById($cartItemId)
    {
        $where = new Where;
        $where->equalTo($this->itemIdField, $cartItemId);

        $result = $this->delete($where);

        return $result->getAffectedRows();
    }

    public function persist(CartLineInterface $item)
    {
        if ($item->getLineItemId() > 0) {
            $where = new Where;
            $where->equalTo($this->itemIdField, $item->getLineItemId());
            $this->update($item, $where);
        } else {
            $result = $this->insert($item);
            $item->setLineItemId($result->getGeneratedValue());
        }

        return $item;
    }

    protected function selectMany($select)
    {
        $resultSet = $this->select($select);

        $return = array();
        foreach ($resultSet as $r) {
            $return[] = $r;
        }

        return $return;
    }

    public function getLineHierarchyBuilder()
    {
        if(!$this->lineHierarchyBuilder) {
            $this->lineHierarchyBuilder = new LineItemHierarchyBuilder;
        }
        return $this->lineHierarchyBuilder;
    }
}
