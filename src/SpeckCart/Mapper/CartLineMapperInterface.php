<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\CartLineInterface;

interface CartLineMapperInterface
{
    public function findById($cartItemId);

    public function findByCartId($cartId);

    public function deleteById($cartItemId);

    public function persist(CartLineInterface $item);
}
