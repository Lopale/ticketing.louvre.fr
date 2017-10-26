<?php

namespace DG\TicketingBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="DG\TicketingBundle\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
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
     * @var bool
     *
     * @ORM\Column(name="reducedPrice", type="boolean")
     */
    private $reducedPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="nameTicket", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $nameTicket;

    /**
     * @var string
     *
     * @ORM\Column(name="firstnameTicket", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $firstnameTicket;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=255)
     * @Assert\Length(min=4)
     */
    private $nationality;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="brithDate", type="date")
     * @Assert\DateTime()
     */
    private $brithDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ticketType", type="string", length=255)
     * @Assert\Length(min=4)
     */
    private $ticketType;

     /**
     * @var int
     *
     * @ORM\Column(name="ticketPrice", type="smallint")
     */
    private $ticketPrice = "0";

     public function __construct()
      {
        $this->ticketType = 'base';
      }

  /**
   * @ORM\ManyToOne(targetEntity="DG\TicketingBundle\Entity\Booking", inversedBy="tickets")
   * @ORM\JoinColumn(nullable=false)
   */
  private $booking;


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
     * Set reducedPrice
     *
     * @param boolean $reducedPrice
     *
     * @return Ticket
     */
    public function setReducedPrice($reducedPrice)
    {
        $this->reducedPrice = $reducedPrice;

        return $this;
    }

    /**
     * Get reducedPrice
     *
     * @return bool
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }

    /**
     * Set nameTicket
     *
     * @param string $nameTicket
     *
     * @return Ticket
     */
    public function setNameTicket($nameTicket)
    {
        $this->nameTicket = $nameTicket;

        return $this;
    }

    /**
     * Get nameTicket
     *
     * @return string
     */
    public function getNameTicket()
    {
        return $this->nameTicket;
    }

    /**
     * Set firstnameTicket
     *
     * @param string $firstnameTicket
     *
     * @return Ticket
     */
    public function setFirstnameTicket($firstnameTicket)
    {
        $this->firstnameTicket = $firstnameTicket;

        return $this;
    }

    /**
     * Get firstnameTicket
     *
     * @return string
     */
    public function getFirstnameTicket()
    {
        return $this->firstnameTicket;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     *
     * @return Ticket
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }


    /**
     * Set brithDate
     *
     * @param string $brithDate
     *
     * @return Ticket
     */
    public function setBrithDate($brithDate)
    {
        $this->brithDate = $brithDate;

        return $this;
    }

    /**
     * Get brithDate
     *
     * @return \DateTime
     */
    public function getBrithDate()
    {
        return $this->brithDate;
    }

    /**
     * Set ticketType
     *
     * @param integer $ticketType
     *
     * @return Ticket
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType
     *
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

  /**
   * @param Bokking $booking
   */
  public function setBokking(Bokking $booking)
  {
    $this->booking = $booking;
  }
  /**
   * @return Bokking
   */
  public function getBokking()
  {
    return $this->booking;
  }

    /**
     * Set booking
     *
     * @param \DG\TicketingBundle\Entity\Booking $booking
     *
     * @return Ticket
     */
    public function setBooking(\DG\TicketingBundle\Entity\Booking $booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return \DG\TicketingBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set bookingNumber
     *
     * @param integer $bookingNumber
     *
     * @return Ticket
     */
    public function setBookingNumber($bookingNumber)
    {
        $this->bookingNumber = $bookingNumber;

        return $this;
    }

    /**
     * Get bookingNumber
     *
     * @return integer
     */
    public function getBookingNumber()
    {
        return $this->bookingNumber;
    }

    /**
     * Set ticketPrice
     *
     * @param integer $ticketPrice
     *
     * @return Ticket
     */
    public function setTicketPrice($ticketPrice)
    {
        $this->ticketPrice = $ticketPrice;

        return $this;
    }

    /**
     * Get ticketPrice
     *
     * @return integer
     */
    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }
}
