<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\Cart;
use SpeckCart\Entity\CartInterface;
use SpeckCart\Entity\CartLineInterface;

use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Session\Container;

class CartService implements CartServiceInterface, EventManagerAwareInterface
{
    protected $sessionManager;
    protected $cartMapper;
    protected $lineMapper;
    protected $eventManager;

    protected $index;

    public function __construct()
    {
        $this->setEventManager(new EventManager());
    }

    public function createSessionCart()
    {
        $container = new Container('speckcart', $this->getSessionManager());

        $cart = new Cart;
        $cart->setCreatedTime(new \DateTime());

        $cart = $this->cartMapper->persist($cart);
        $container->cartId = $cart->getCartId();
        return $cart;
    }

    public function getSessionCart($create = false)
    {
        $container = new Container('speckcart', $this->getSessionManager());

        if (!isset($container->cartId)) {
            if ($create) {
                $cart = $this->createSessionCart();
            } else {
                $cart = new Cart;
                $cart->setCreatedTime(new \DateTime());
            }
        } else {
            $cart = $this->cartMapper->findById($container->cartId);
            $lines = $this->itemMapper->findByCartId($cart->getCartId());

            $cart->setLineItems($lines);
        }

        return $cart;
    }

    public function findById($cartId)
    {
        return $this->cartMapper->findById($cartId);
    }

    public function findLineById($lineId)
    {
        return $this->lineMapper->findById($lineId);
    }

    public function persist(CartInterface $cart)
    {
        return $this->cartMapper->persist($cart);
    }

    public function persistLine(CartLineInterface $line)
    {
        return $this->lineMapper->persist($line);
    }

    public function onAddLine(Event $e)
    {
        $this->addLineToCart($e->getCartLine());
        $this->getEventManager()->trigger(CartEvent::EVENT_ADD_LINE_POST, $this, $e->getParams());
    }

    public function addLineToCart(CartLineInterface $line, CartInterface $cart = null)
    {
        if ($cart === null) {
            $cart = $this->getSessionCart(true);
        }

        $line->setCartId($cart->getCartId())
            ->setAddedTime(new \DateTime());
        $this->lineMapper->persist($line);

        $this->persistCartLineChildren($line->getLineItems(), $line, $cart);

        $cart->addLineItem($line);

        return $this;
    }

    protected function persistCartLineChildren(array $children, CartLineInterface $parent, CartInterface $cart)
    {
        foreach ($children as $i) {
            $i->setCartId($cart->getCartId())
                ->setAddedTime(new \DateTime())
                ->setParentLine($parent);

            $this->lineMapper->persist($i);
            $this->persistCartLineChildren($i->getLineItems(), $i, $cart);
        }
    }

    public function removeLineFromCart($lineId, CartInterface $cart = null)
    {
        if ($cart === null) {
            $cart = $this->getSessionCart();
        }

        $this->lineMapper->deleteById($lineId);
        $cart->removeLine($lineId);

        return $this;
    }

    public function attachDefaultListeners()
    {
        $events = $this->getEventManager();
        $events->attach(CartEvent::EVENT_ADD_LINE, array($this, 'onAddLine'));
        //$events->attach(CartEvent::EVENT_REMOVE_LINE, array($this, 'onRemoveLine'));
    }

    public function getSessionManager()
    {
        if ($this->sessionManager === null) {
            $this->sessionManager = Container::getDefaultManager();
        }

        return $this->sessionManager;
    }

    public function setSessionManager($sessionManager)
    {
        $this->sessionManager = $sessionManager;
        return $this;
    }

    public function getCartMapper()
    {
        return $this->cartMapper;
    }

    public function setCartMapper($cartMapper)
    {
        $this->cartMapper = $cartMapper;
        return $this;
    }

    public function getLineMapper()
    {
        return $this->lineMapper;
    }

    public function setLineMapper($lineMapper)
    {
        $this->lineMapper = $lineMapper;
        return $this;
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(
            __CLASS__,
            get_called_class(),
            'speckcart'
        );

        $eventManager->setEventClass('SpeckCart\Service\CartEvent');

        $this->eventManager = $eventManager;
        return $this;
    }
}
