<?php

namespace SpeckCartTest\Service;

use PHPUnit_Framework_TestCase;
use Mockery;
use SpeckCartTest\Bootstrap;
use SpeckCart\Entity\CartLine;
use SpeckCart\Entity\Item;
use SpeckCart\Service\CartEvent;
use SpeckCart\Service\CartService;
use SpeckCartTest\TestAsset\SessionManager;

use Zend\Session\Container;


class CartServiceTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->cartService = new CartService();
        $this->sessionManager = new SessionManager;
        $this->cartMapper = Mockery::mock('SpeckCart\\Mapper\\CartMapperInterface');

        $this->cartService->setSessionManager($this->sessionManager);
        $this->cartService->setCartMapper($this->cartMapper);
        $container = new Container('speckcart', $this->sessionManager);
        unset($container->cartId);
    }


    public function testInitialCartIsEmpty()
    {
        $cart = $this->cartService->getSessionCart();
        $this->assertInstanceOf('SpeckCart\Entity\Cart', $cart);
        $this->assertEquals(0, count($cart->getLineItems()));
    }

    public function testAddToCart()
    {
        // @todo add assertions for calls to mocked mapper
        $line = new CartLine;
        $return = $this->cartService->addLineToCart($line);

        // check fluent interface
        $this->assertSame($return, $this->cartService);

        // check the lineitem was added
        $this->assertEquals(1, count($this->cartService->getSessionCart()->getLineItems()));

        // check that it's the same item still
        $lineAddedToCart = $this->cartService->getSessionCart()->getLineItems();
        $this->assertSame($line, array_pop($itemAddedToCart));
    }

    public function testAddUsingEvent()
    {
        // @todo add assertions for calls to mocked mapper
        $event = new CartEvent;
        $event->setCartLine(new CartLine);

        $this->cartService->onAddLine($event);

        // check that it's the same item still
        $lineAddedToCart = $this->cartService->getSessionCart()->getLineItems();
        $this->assertSame($line, array_pop($itemAddedToCart));
    }

    public function testDuplicateItemsAreNotAdded()
    {
        $line = new CartLine;

        $this->cartService->addLineToCart($line);
        $this->cartService->addLineToCart($line);

        $this->assertEquals(1, count($this->cartService->getSessionCart()->getLineItems()));
    }

    public function testRecursiveItems()
    {
        $parent = new CartLine;
        $child = new CartLine;

        $parent->addLineItem($child);

        $this->cartService->addLineToCart($parent);
        $lines = $this->cartService->getSessionCart()->getLineItems();

        $parentFromCart = array_pop($lines);
        $this->assertSame($parentFromCart, $parent);

        $this->assertEquals(1, count($parentFromCart->getLineItems()));

        $this->assertSame($child, array_pop($parentFromCart->getLineItems()));
    }

    public function testRemoveFromCart()
    {
        // @todo add assertions for calls to mocked mapper
        $line = new CartLine;
        $line->setLineItemId(1);

        $return = $this->cartService->addLineToCart($line);

        // ensure it was added first
        $this->assertEquals(1, count($this->cartService->getSessionCart()->getLineItems()));

        $this->cartService->removeLineFromCart(1);

        // ensure it was removed
        $this->assertEquals(0, count($this->cartService->getSessionCart()->getLineItems()));
    }
}
