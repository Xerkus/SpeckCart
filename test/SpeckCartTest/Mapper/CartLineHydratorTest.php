<?php

namespace SpeckCartTest\Mapper;

use DateTime;
use PHPUnit_Framework_TestCase;
use SpeckCart\Entity\CartLine;
use SpeckCart\Mapper\CartLineHydrator;

class CartLineHydratorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->cartLine = new CartLine;
        $this->cartLine->setItem(new TestAsset\TestItem());
        $this->cartLine->setAddedTime(new DateTime());
    }

    public function testHydratorRestoresItemClass()
    {
        $hydrator = new CartLineHydrator;
        $data = $hydrator->extract($this->cartLine);

        $restored = $hydrator->hydrate($data, new CartLine);
        $this->assertInstanceOf('SpeckCartTest\\Mapper\\TestAsset\\TestItem', $restored->getItem());
    }

    public function testHydratorUsesDefaultItemClassIfSpecifiedClassMissing()
    {
        $hydrator = new CartLineHydrator;
        $data = $hydrator->extract($this->cartLine);
        $data['item_type'] = 'NonExistantClass';

        $restored = $hydrator->hydrate($data, new CartLine);
        $this->assertEquals('SpeckCart\\Entity\\Item', get_class($restored->getItem()));
    }
}
