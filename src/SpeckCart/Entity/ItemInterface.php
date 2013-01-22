<?php

namespace SpeckCart\Entity;

interface ItemInterface
{
    public function getName();

    public function setName($name);

    public function getDescription();

    public function setDescription($description);

    public function getMetadata();

    public function setMetadata(array $metadata);

}
