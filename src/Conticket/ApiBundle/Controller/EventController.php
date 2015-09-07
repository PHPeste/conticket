<?php

namespace Conticket\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;

use Conticket\ApiBundle\Handler\EventHandler;
use Conticket\ApiBundle\Document\Event;
use Conticket\ApiBundle\Form\Type\EventType;

final class EventController extends FOSRestController implements ClassResourceInterface
{
    /* @var Conticket\ApiBundle\Handler\EventHandler */
    private $handler;
    
    public function __construct(EventHandler $handler) 
    {
        $this->handler = $handler;
    }
    
    /**
     * List all events.
     *
     * @return array
     */
    public function cgetAction()
    {
        return ['events' => $this->handler->all()];
    }
    
    /**
     * List an event
     *
     * @param mixed $id
     *
     * @return array
     */
    public function getAction($id)
    {
        return ['event' => $this->getOr404($id)];
    }
    
    /**
     * Create an event
     *
     * @param Request $$request
     *
     * @return redirect
     */
    public function postAction(Request $request)
    {
        $data     = $request->request->all();
        $document = new Event();
        $form     = new EventType();
        $code     = Codes::HTTP_CREATED;
        
        $post = $this->handler->post($document, $form, $data);
        
        return $this->routeRedirectView('get_event', ['id' => $post->getId()], $code);
    }
    
    /**
     * Update an event
     *
     * @param Request $request
     * @param mixed $id
     *
     * @return redirect
     */
    public function putAction(Request $request, $id)
    {
        $data     = $request->request->all();
        $document = $this->getOr404($id);
        $form     = new EventType();
        $code     = Codes::HTTP_NO_CONTENT;
        
        $post = $this->handler->put($document, $form, $data);
        
        return $this->routeRedirectView('get_event', ['id' => $post->getId()], $code);
    }
    
    /**
     * Fetch a Event or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return DocumentInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($event = $this->handler->find($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $event;
    }
}
