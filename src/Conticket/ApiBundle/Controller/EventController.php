<?php

namespace Conticket\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class EventController extends Controller
{
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getManager();

        return $this->render('ApiBundle:Default:index.html.twig');
    }

    public function createAction()
    {
        exit('adsas');
    }
}
