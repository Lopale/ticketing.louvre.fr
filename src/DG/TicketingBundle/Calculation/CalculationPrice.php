<?php

namespace DG\TicketingBundle\Calculation;


use Doctrine\ORM\EntityManager;

// Entity
use DG\TicketingBundle\Entity\Ticket;


class CalculationPrice
{


	/*
	Liste des fonction a créer

	X - compter le nombre de billet vendu le jour choisi et vérifier que le total est inférieur à 1000 entrée
	X - Vérifier si un billet est en tarif réduit
	X - Vérifier si les billets sont en demi journée
	X - Si demi journée divise le prix en 2
	X - vérifier l'âge du propriétaire du billet et assigner le bon Type de billet et prix
	X - Calculer le coût total de la booking
	X - Enregistre prix billet en BDD
	X - Enregistre total booking en BDD

	X - Mettre nombre de billet, Type de billet et tarifs dans paramètre.yml (actuellement dans app/config/services.yml)

	*/
	/**
	* @var EntityManagerInterface
	*/
    private $em;
	
	private $tarif_reduit;
	private $min_age_bebe;
	private $max_age_bebe;
	private $tarif_age_bebe;
    private $name_ticket_bebe;
	private $min_age_enfant;
	private $max_age_enfant;
	private $tarif_age_enfant;
    private $name_ticket_enfant;
	private $min_age_normal;
	private $max_age_normal;
	private $tarif_age_normal;
    private $name_ticket_normal;
	private $min_age_senior;
	private $tarif_age_senior;
    private $name_ticket_senior;
    private $name_ticket_reduit;
	private $max_tickets;

    /**
     * @var int
     */
    private $commandPrice;


    public function __construct(EntityManager $em, $tarif_reduit, $min_age_bebe, $max_age_bebe, $tarif_age_bebe, $min_age_enfant, $max_age_enfant, $tarif_age_enfant, $min_age_normal, $max_age_normal, $tarif_age_normal, $min_age_senior, $tarif_age_senior, $max_tickets, $name_ticket_bebe, $name_ticket_enfant, $name_ticket_normal, $name_ticket_senior, $name_ticket_reduit)
    {

    	$this->em 					= $em;

		$this->tarif_reduit 		= $tarif_reduit;
		$this->min_age_bebe 		= $min_age_bebe;
		$this->max_age_bebe 		= $max_age_bebe;
		$this->tarif_age_bebe 		= $tarif_age_bebe;
		$this->name_ticket_bebe 	= $name_ticket_bebe;
		$this->min_age_enfant 		= $min_age_enfant;
		$this->max_age_enfant 		= $max_age_enfant;
		$this->tarif_age_enfant 	= $tarif_age_enfant;
		$this->name_ticket_enfant 	= $name_ticket_enfant;
		$this->min_age_normal 		= $min_age_normal;
		$this->max_age_normal 		= $max_age_normal;
		$this->tarif_age_normal 	= $tarif_age_normal;
		$this->name_ticket_normal 	= $name_ticket_normal;
		$this->min_age_senior 		= $min_age_senior;
		$this->tarif_age_senior 	= $tarif_age_senior;
		$this->name_ticket_senior 	= $name_ticket_senior;
		$this->name_ticket_reduit 	= $name_ticket_reduit;
		$this->max_tickets 			= $max_tickets;
    }



	public function nbTicketsAlreadySell($visiteDay){

		$result =  count(
            $this->em->getRepository('DGTicketingBundle:Ticket')
                           ->nbTicketsAlreadySellBis($visiteDay)
        );



		//return $result;

        if($result >= $this->max_tickets){
        	return false;
        }else{
	        return true;        	
        }

		
	}

	// public function durationBooking($durationBooking){
	// 	if($durationBooking ==1){
	// 		echo "Vous venez une demi-journée<br/>";
	// 	}
	// 	if($durationBooking ==2){
	// 		echo "Vous venez une journée<br/>";
	// 	}

	// }


	public function tarifBillet($brithDate, $visiteDay, $reducedPrice, $durationBooking){

		// On transforme les 2 dates en timestamp
		$brithDate = strtotime($brithDate);
		$visiteDay = strtotime($visiteDay);
		 
		// On récupère la différence de timestamp entre les 2 précédents
		$nbJoursTimestamp = $brithDate - $visiteDay;
		 
		// ** Pour convertir le timestamp (exprimé en secondes) en année **
		$nbAnnees = $nbJoursTimestamp/31553280; // 31 553 280 = 60*60*24*365.25

		// On tronque le nombre d'années
		$nbAnnees = intval($nbAnnees);


		if( $nbAnnees < $this->max_age_bebe){
			$ticketPrice = $this->tarif_age_bebe; // Ticket gratuit - de 4 ans
			$ticketName = $this->name_ticket_bebe;
		}
		elseif($nbAnnees >= $this->min_age_enfant && $nbAnnees <= $this->min_age_normal){
			$ticketPrice = $this->tarif_age_enfant;			// Ticket réduit enfant
			$ticketName = $this->name_ticket_enfant;
		}
		elseif($nbAnnees > $this->min_age_normal && $nbAnnees <= $this->max_age_normal){
			$ticketPrice = $this->tarif_age_normal;			// Ticket normal
			$ticketName = $this->name_ticket_normal;
		}
		elseif($nbAnnees > $this->min_age_senior){
			$ticketPrice = $this->tarif_age_senior;			// Ticket senior
			$ticketName = $this->name_ticket_senior;
		}


		// Tarif réduit
		if($reducedPrice && $nbAnnees > $this->min_age_normal){
			$ticketPrice = $this->tarif_reduit;
			$ticketName = $this->name_ticket_reduit;
		}

		// Demi journée ou journée
		$ticketPrice = $ticketPrice * $durationBooking;

		$DetailTicket = array($ticketPrice,$ticketName);

		return $DetailTicket;

	}


	public function totalPrice($listTickets){

		//var_dump($listTickets);
		
		$totalPrice = 0;

		for($i = 0; $i < count($listTickets); ++$i) {
			
			$totalPrice = $totalPrice + $listTickets[$i]->getTicketPrice();
		}

		return $totalPrice;
		

	}

	public function setPriceFromOrder()
    {

        $tickets = $booking->getTickets();

        foreach ($tickets as $ticket) {
            $ticket->getTicketPrice($price);
            // Define the command price using every tickets price set earlier.
            $this->commandPrice += $ticket->getTicketPrice();
            $TotalBooking->setTotalBooking($this->commandPrice);
            // Link the tickets to an Order, this way, every ticket has a parent.
            //$ticket->setbooking($booking);
        }
        //echo 'ici '.$TotalBooking;
        //return $TotalBooking;
    }


}