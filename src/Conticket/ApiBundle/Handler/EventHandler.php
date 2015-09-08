<?php
    
namespace Conticket\ApiBundle\Handler;

final class EventHandler extends AbstractHandler
{
    const REPOSITORY_CLASS_NAME = 'ConticketApiBundle:Event';
    
    public function getRepositoryClassName()
    {
        return static::REPOSITORY_CLASS_NAME;
    }
}
