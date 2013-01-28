<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\Cart;
use SpeckCart\Entity\CartInterface;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

use ZfcBase\Mapper\AbstractDbMapper;

class CartMapperZendDb extends AbstractDbMapper implements CartMapperInterface
{
    protected $tableName = 'cart';
    protected $cartIdField = 'cart_id';

    public function __construct()
    {
        $this->setEntityPrototype(new Cart);
        $this->setHydrator(new CartHydrator);
    }

    public function findById($cartId)
    {
        $select = $this->getSelect();

        $where = new Where;
        $where->equalTo($this->cartIdField, $cartId);

        $resultSet = $this->select($select->where($where));
        return $resultSet->current();
    }

    public function persist(CartInterface $cart)
    {
        if ($cart->getCartId() > 0) {
            $where = new Where;
            $where->equalTo($this->cartIdField, $cart->getCartId());

            $this->update($cart, $where);
        } else {
            $result = $this->insert($cart);
            $cart->setCartId($result->getGeneratedValue());
        }

        return $cart;
    }
}
