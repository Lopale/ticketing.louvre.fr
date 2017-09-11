<?php

namespace DG\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
  public function indexAction()
  {
    $content = $this->get('templating')->render('DGTicketingBundle:Booking:index.html.twig');
    
    return new Response($content);
  }
}