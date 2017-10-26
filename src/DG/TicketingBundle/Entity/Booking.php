<?php

namespace DG\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

// On rajoute ce use pour la contrainte :
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
// N'oubliez pas de rajouter ce « use », il définit le namespace pour les annotations de validation
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="DG\TicketingBundle\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
{


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookingDate", type="datetime")
     * @Assert\DateTime()
     */
    private $bookingDate;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="visiteDay", type="datetime")
     * @Assert\DateTime()
     */
    private $visiteDay;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150)
     * @Assert\Length(min=6)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="bookingNumber", type="smallint")
     */
    private $bookingNumber = "1234";

    /**
   * @ORM\Column(name="bookingTerminated", type="boolean")
   */
    private $bookingTerminated = false;


        /**
     * @var int
     *
     * @ORM\Column(name="durationBooking", type="smallint")
     */
    private $durationBooking;

     /**
     * @var int
     *
     * @ORM\Column(name="totalBooking", type="smallint")
     */
    private $totalBooking;

     /**
     * @var string
     *
     * @ORM\Column(name="customerName", type="string", length=255)
     * @Assert\Length(min=4)
     */
    private $customerName ="Nom Du titulaire de la carte";


  /**
   * @ORM\OneToMany(targetEntity="DG\TicketingBundle\Entity\Ticket", mappedBy="booking", cascade={"persist"})
   */
  private $tickets; // Notez le « s », une annonce est liée à plusieurs candidatures



    public function __construct()
      {
        // Par défaut, la date de la Réservation est la date d'aujourd'hui
        $this->bookingDate = new \Datetime();
        // La date de viste par defaut est le lundi suivant, pour éviter que le jour par défault ne sois pas un jour non ouvrable
        $this->visiteDay = new \Datetime(date('d-m-Y', strtotime(date('d-m-Y').' NEXT MONDAY')));
        // Par défaut, le total de la commande est de 0 €
        $this->totalBooking = '0';
        $this->tickets = new ArrayCollection();
      }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bookingDate
     *
     * @param \DateTime $bookingDate
     *
     * @return Booking
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return \DateTime
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set bookingNumber
     *
     * @param integer $bookingNumber
     *
     * @return Booking
     */
    public function setBookingNumber($bookingNumber)
    {
        $this->bookingNumber = $bookingNumber;

        return $this;
    }

    /**
     * Get bookingNumber
     *
     * @return int
     */
    public function getBookingNumber()
    {
        return $this->bookingNumber;
    }

    /**
     * Set durationBooking
     *
     * @param integer $durationBooking
     *
     * @return Booking
     */
    public function setDurationBooking($durationBooking)
    {
        $this->durationBooking = $durationBooking;

        return $this;
    }

    /**
     * Get durationBooking
     *
     * @return int
     */
    public function getDurationBooking()
    {
        return $this->durationBooking;
    }

    /**
     * Set terminated
     *
     * @param boolean $terminated
     *
     * @return Booking
     */
    public function setTerminated($terminated)
    {
        $this->terminated = $terminated;

        return $this;
    }

    /**
     * Get terminated
     *
     * @return boolean
     */
    public function getTerminated()
    {
        return $this->terminated;
    }

    /**
     * Set visiteDay
     *
     * @param \DateTime $visiteDay
     *
     * @return Booking
     */
    public function setVisiteDay($visiteDay)
    {
        $this->visiteDay = $visiteDay;

        return $this;
    }

    /**
     * Get visiteDay
     *
     * @return \DateTime
     */
    public function getVisiteDay()
    {
        return $this->visiteDay;
    }

    /**
     * Set bookingTerminated
     *
     * @param boolean $bookingTerminated
     *
     * @return Booking
     */
    public function setBookingTerminated($bookingTerminated)
    {
        $this->BookingTerminated = $bookingTerminated;

        return $this;
    }

    /**
     * Get bookingTerminated
     *
     * @return boolean
     */
    public function getBookingTerminated()
    {
        return $this->BookingTerminated;
    }




    
  /**
   * @param Ticket $ticket
   */
  public function addTicket(Ticket $ticket)
  {
    $this->tickets[] = $ticket;
    // On lie l'annonce à la candidature
    $ticket->setBooking($this);
  }
  /**
   * @param Ticket $ticket
   */
  public function removeTicket(Ticket $ticket)
  {
    $this->tickets->removeElement($ticket);
  }
  /**
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getTickets()
  {
    return $this->tickets;
  }

  

    /**
     * Set totalBooking
     *
     * @param integer $totalBooking
     *
     * @return Booking
     */
    public function setTotalBooking($totalBooking)
    {
        $this->totalBooking = $totalBooking;

        return $this;
    }

    /**
     * Get totalBooking
     *
     * @return integer
     */
    public function getTotalBooking()
    {
        return $this->totalBooking;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Booking
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }
}
