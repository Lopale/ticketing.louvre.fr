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

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use DG\TicketingBundle\Calculation\Calculationprice;

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

      /* Début Test Service */
      //var_dump($booking);

     

      // On récupère le service
      $calculationprice = $this->container->get('dg_ticketing.calculationprice');





      // On récupère l'annonce $booking->getId()
    $booking = $em->getRepository('DGTicketingBundle:Booking')->find($booking->getId());

    // On récupère la liste des billets de cette commande
    $listTickets = $em
      ->getRepository('DGTicketingBundle:Ticket')
      ->findBy(array('booking' => $booking))
    ;

      // $calculationprice->durationBooking($booking->getDurationBooking());
      // $booking->setDurationBooking($booking->getDurationBooking());
    //var_dump($listTickets);
    //Test calcul age

    for($i = 0; $i < count($listTickets); ++$i) {
        $DetailTicket = $calculationprice->tarifBillet(date_format($booking->getVisiteDay(),"Y/m/d H:i:s"), date_format($listTickets[$i]->getBrithDate(),"Y/m/d H:i:s"),$listTickets[$i]->getReducedPrice(), $booking->getDurationBooking());


        // Récupérer la variable $ticketPrice
        //$ticketPrice = $calculationprice->tarifBillet();

        $listTickets[$i]->setTicketPrice($DetailTicket[0]);
        $listTickets[$i]->setTicketType($DetailTicket[1]);
        
        $em->flush();


    }

    $totalCommande = $calculationprice->totalPrice($listTickets);
    $booking->setTotalBooking($totalCommande);

    $em->flush();

      //die();
      /* Fin Test Service */

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
      
      return $this->redirectToRoute('dg_ticketing_view', array('id' => $booking->getId()));
    }
    return $this->render('DGTicketingBundle:Booking:add.html.twig', array(
      'form' => $form->createView(),
    ));

  }


  public function viewAction($id)
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





  public function paiementAction($id, Request $request)
  {


    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $booking = $em->getRepository('DGTicketingBundle:Booking')->find($id);

    if (null === $booking) {
      throw new NotFoundHttpException("La commande d'id ".$id." n'existe pas.");
    }

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $booking);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('id',                 TextType::class)
      ->add('totalBooking',       TextType::class)
      ->add('customerName',       TextType::class)
      //->add("inputName", TextType::class , array("mapped"=>false, "data"=>2, "label"=>'Nom Du titulaire de la carte'))
      ->add("code", TextType::class , array(
          "mapped"=>false,
          'attr' => array('data-stripe' => 'number'),
           "label"=>'Code de carte bleu'))
      ->add("validityMonth", TextType::class , array(
          "mapped"=>false,
          'attr' => array('data-stripe' => 'exp_month'),
           "label"=>'Mois de validité'))
      ->add("validityYear", TextType::class , array(
          "mapped"=>false,
          'attr' => array('data-stripe' => 'exp_year'),
           "label"=>'Année de validité'))
      ->add("crypto", TextType::class , array(
          "mapped"=>false,
          'attr' => array('data-stripe' => 'cvc'),
           "label"=>'Cryptogramme'))
      ->add('Valider',            SubmitType::class);
    ;
    // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();


    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      // SI on a soumis le formulaire
      
    }


    return $this->render('DGTicketingBundle:Booking:paiement.html.twig', array(
      'booking' => $booking,
      'form' => $form->createView(),
    ));


  }



}