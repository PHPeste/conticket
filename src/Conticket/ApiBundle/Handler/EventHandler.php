<?php
    
namespace Conticket\ApiBundle\Handler;

final class EventHandler extends AbstractHandler
{
    public function getRepositoryClassName()
    {
        return 'ConticketApiBundle:Event';
    }
}
