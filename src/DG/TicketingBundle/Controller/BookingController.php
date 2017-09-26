<?php

namespace DG\TicketingBundle\Controller;

use DG\TicketingBundle\Entity\Booking;
use DG\TicketingBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints as Assert;


class BookingController extends Controller
{


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


  public function indexAction($page)
  {

    if ($page < 1) {
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    // On crée un objet Booking
    $booking = new Booking();

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $booking);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('visiteDay',   DateType::class, array(
                                'widget' => 'single_text',
                                'html5' => false,
                                'format' => "dd/MM/yyyy",
                                'constraints' => [
                                  new Assert\Range(array(
                                    'min'=>'now',
                                    'minMessage'=>"La date ne peut pas être passé"
                                  ))
                                ],
                                'attr' => ['class' => 'js-datepicker'],
                                'required' => true
                            ))
      ->add('email',     EmailType::class, array('required' => true))
      //->add('number',    NumberType::class, array('required' => true))
      ->add('Valider',      SubmitType::class)
    ;
    

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DGTicketingBundle:Booking:index.html.twig', array(
      'form' => $form->createView(),
    ));

  }

  
  public function addAction(Request $request)
  {
    // Création de l'entité
    $booking = new Booking();
    $booking->setEmail('test@blabla.fr');
    $booking->setBookingNumber(5678);
    $booking->setVisiteDay(new \Datetime('2017-09-24 08:14:44'));

    // Création d'un premier ticket
    $ticket1 = new Ticket();
    $ticket1->setReducedPrice(false);
    $ticket1->setVisitDay(new \Datetime('2017-09-24 08:14:44'));
    $ticket1->setNameTicket('GRILLON');
    $ticket1->setFirstnameTicket('David');
    $ticket1->setBrithDate(new \Datetime('1987-12-22 08:14:44'));
    $ticket1->setTicketType(2);

    // Création d'un deuxième ticket par exemple
    $ticket2 = new Ticket();
    $ticket2->setReducedPrice(false);
    $ticket2->setVisitDay(new \Datetime('2017-09-24 08:14:44'));
    $ticket2->setNameTicket('MARAUX');
    $ticket2->setFirstnameTicket('Clara');
    $ticket2->setBrithDate(new \Datetime('1992-10-23 08:14:44'));
    $ticket2->setTicketType(2);

    // On lie les tickets à la commande
    $ticket1->setBooking($booking);
    $ticket2->setBooking($booking);
    
    // On peut ne pas définir ni la date ni la publication,
    // car ces attributs sont définis automatiquement dans le constructeur

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($booking);

     // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
    // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
    $em->persist($ticket1);
    $em->persist($ticket2);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // Reste de la méthode qu'on avait déjà écrit
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('dg_ticketing_view', array('id' => $advert->getId()));
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('DGTicketingBundle:Booking:index.html.twig', array('booking' => $booking));
  }



}