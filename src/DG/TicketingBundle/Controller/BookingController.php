<?php

namespace DG\TicketingBundle\Controller;

use DG\TicketingBundle\Entity\Booking;
use DG\TicketingBundle\Entity\Ticket;
use DG\TicketingBundle\Form\BookingType;
use DG\TicketingBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




class BookingController extends Controller
{


  



   


  public function indexAction($page)
  {
    if ($page < 1) {
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }
  }

  
  public function addAction(Request $request)
  {
    // On crée un objet Booking
    $booking = new Booking();

    $form   = $this->get('form.factory')->create(BookingType::class, $booking);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->persist($booking);
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
      return $this->redirectToRoute('dg_ticketing_ticket', array('id' => $booking->getId()));
    }
    return $this->render('DGTicketingBundle:Booking:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }


  public function ticketAction($id, Request $request)
  {
    
    // On crée un objet Booking
    $ticket = new Ticket();

    $form   = $this->get('form.factory')->create(TicketType::class, $ticket);

    return $this->render('DGTicketingBundle:Booking:ticket.html.twig', array(
      'form' => $form->createView(),
    ));

  }


  


  public function viewAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $booking = $em->getRepository('DGTicketingBundle:Booking')->find($id);

    if (null === $booking) {
      throw new NotFoundHttpException("La commande d'id ".$id." n'existe pas.");
    }


    // On récupère la liste des billets de cette commande
    $listTickets = $em
      ->getRepository('DGTicketingBundle:Ticket')
      ->findBy(array('booking' => $booking))
    ;


    // Le render ne change pas, on passait avant un tableau, maintenant un objet
    return $this->render('DGTicketingBundle:Booking:view.html.twig', array(
      'booking' => $booking,
      'listTickets' => $listTickets
    ));
  }


}