<?php

namespace SpeckCart\Entity;

class Item implements ItemInterface
{
    protected $name;
    protected $decription;
    protected $metadata;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        $this->decription;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
