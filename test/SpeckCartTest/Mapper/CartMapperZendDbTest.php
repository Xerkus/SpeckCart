<?php

namespace SpeckCartTest\Mapper;

use PHPUnit_Framework_TestCase;
use SpeckCart\Entity\Cart;
use SpeckCart\Mapper\CartMapperZendDb;
use SpeckCartTest\Bootstrap;

class CartMapperZendDbTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->markTestIncomplete('Test is not updated yet');
    }

    public function testPersistInsert()
    {
        $time = new \DateTime();

        $cart = new Cart;
        $cart->setCreatedTime($time);

        $result1 = $this->mapper->persist($cart);
        $this->assertEquals(1, $result1->getCartId());

        $cart = $this->mapper->findById(1);
        $this->assertEquals(1, $cart->getCartId());
        $this->assertEquals($time->format('c'), $cart->getCreatedTime()->format('c'));
    }

    public function testPersistUpdate()
    {
        $time = new \DateTime();

        $cart = new Cart;
        $cart->setCartId(1);
        $cart->setCreatedTime($time);
        $this->mapper->persist($cart);

        $cart = $this->mapper->findById(1);
        $this->assertEquals(1, $cart->getCartId());
        $this->assertEquals($time->format('c'), $cart->getCreatedTime()->format('c'));
    }

    public function testFindById()
    {
        $cart = $this->mapper->findById(1);
        $this->assertEquals(1, $cart->getCartId());
    }
}
