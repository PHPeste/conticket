<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument */
abstract class Gateway
{
    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $type;

    /** @ODM\String */
    private $key;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $type
     * @param string $key
     */
    public function __construct($name, $type, $key)
    {
        $this->name = $name;
        $this->type = $type;
        $this->key  = $key;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getKey()
    {
        return $this->key;
    }
}
