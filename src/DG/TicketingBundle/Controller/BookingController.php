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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

      // echo "Vous venez le : ".date_format($booking->getVisiteDay(),"Y/m/d H:i:s")."<br/>";
      // echo "Vous avez fait votre réservation le : ".date_format($booking->getBookingDate(),"Y/m/d H:i:s")."<br/>";
      // echo "Email à laquelle envoyer les  tickets : ".$booking->getEmail()."<br/>";
      // Test calcul age en dur
      //$calculationprice->age(date_format($booking->getVisiteDay(),"Y/m/d H:i:s"), '22-12-1987');
      //echo "<br/>";
     // $calculationprice->durationBooking($booking->getDurationBooking());


      // On récupère l'annonce $booking->getId()
    $booking = $em->getRepository('DGTicketingBundle:Booking')->find($booking->getId());

    // On récupère la liste des billets de cette commande
    $listTickets = $em
      ->getRepository('DGTicketingBundle:Ticket')
      ->findBy(array('booking' => $booking))
    ;


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



  public function paiementAction($id)
  {


    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $booking = $em->getRepository('DGTicketingBundle:Booking')->find($id);

    if (null === $booking) {
      throw new NotFoundHttpException("La commande d'id ".$id." n'existe pas.");
    }


    return $this->render('DGTicketingBundle:Booking:paiement.html.twig', array(
      'booking' => $booking
    ));


  }


  /**
     * @Route(
     *     "/checkout",
     *     name="order_checkout",
     *     methods="POST"
     * )
     */
    public function terminatedAction(Request $request)
    {
        \Stripe\Stripe::setApiKey("sk_test_p9SLzumPEoQLhxeZVsPWUCL7");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 1000, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - OpenClassrooms Exemple"
            ));
            $this->addFlash("success","Bravo ça marche !");
            //return $this->redirectToRoute("order_prepare");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Snif ça marche pas :(");
            //return $this->redirectToRoute("order_prepare");
            // The card has been declined
        }
    }



}