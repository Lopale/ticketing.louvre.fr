<?php

namespace Tests\TicketingBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DG\TicketingBundle\Entity\Ticket;

class TicketTest extends WebTestCase
{
	
	public function testSetNameTicket()
    {
        $ticket = new Ticket();
        $nameTicket = 'GRILLON';
        $ticket->setNameTicket($nameTicket);
        $this->assertEquals('GRILLON', $ticket->getNameTicket());
    }
    public function testSetFirstNameTicket()
    {
        $ticket = new Ticket();
        $firstnameTicket = 'David';
        $ticket->setFirstnameTicket($firstnameTicket);
        $this->assertEquals('David', $ticket->getFirstnameTicket());
    }
}