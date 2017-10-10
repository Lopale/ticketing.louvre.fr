<?php

namespace DG\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DurationTicket
 *
 * @ORM\Table(name="duration_ticket")
 * @ORM\Entity(repositoryClass="DG\TicketingBundle\Repository\DurationTicketRepository")
 */
class DurationTicket
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
     * @var string
     *
     * @ORM\Column(name="nameDuration", type="string", length=255)
     */
    private $nameDuration;


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
     * Set nameDuration
     *
     * @param string $nameDuration
     *
     * @return DurationTicket
     */
    public function setNameDuration($nameDuration)
    {
        $this->nameDuration = $nameDuration;

        return $this;
    }

    /**
     * Get nameDuration
     *
     * @return string
     */
    public function getNameDuration()
    {
        return $this->nameDuration;
    }

    /**
     * Set ticket
     *
     * @param \DG\TicketingBundle\Entity\Ticket $ticket
     *
     * @return DurationTicket
     */
    public function setTicket(\DG\TicketingBundle\Entity\Ticket $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \DG\TicketingBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
