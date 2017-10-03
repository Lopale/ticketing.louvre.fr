<?php

namespace DG\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="DG\TicketingBundle\Repository\BookingRepository")
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
     */
    private $bookingDate;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="visiteDay", type="datetime")
     */
    private $visiteDay;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150)
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



    public function __construct()
      {
        // Par défaut, la date de la Réservation est la date d'aujourd'hui
        $this->bookingDate = new \Datetime();
        $this->visiteDay = new \Datetime();
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
}
