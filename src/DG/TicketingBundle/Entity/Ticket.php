<?php

namespace DG\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="DG\TicketingBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
   * @ORM\ManyToOne(targetEntity="DG\TicketingBundle\Entity\Booking")
   * @ORM\JoinColumn(nullable=false)
   */
     private $booking;
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
     * @var \DateTime
     *
     * @ORM\Column(name="visitDay", type="date")
     */
    private $visitDay;

    /**
     * @var string
     *
     * @ORM\Column(name="nameTicket", type="string", length=255)
     */
    private $nameTicket;

    /**
     * @var string
     *
     * @ORM\Column(name="firstnameTicket", type="string", length=255)
     */
    private $firstnameTicket;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="brithDate", type="date")
     */
    private $brithDate;

    /**
     * @var int
     *
     * @ORM\Column(name="ticketType", type="smallint")
     */
    private $ticketType;


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
     * Set visitDay
     *
     * @param \DateTime $visitDay
     *
     * @return Ticket
     */
    public function setVisitDay($visitDay)
    {
        $this->visitDay = $visitDay;

        return $this;
    }

    /**
     * Get visitDay
     *
     * @return \DateTime
     */
    public function getVisitDay()
    {
        return $this->visitDay;
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
     * @return int
     */
    public function getTicketType()
    {
        return $this->ticketType;
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
}
