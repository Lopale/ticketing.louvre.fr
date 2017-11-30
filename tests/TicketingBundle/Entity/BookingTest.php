<?php

namespace Tests\TicketingBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DG\TicketingBundle\Entity\Booking;
use DG\TicketingBundle\Entity\Ticket;
use DG\TicketingBundle\Calculation\Calculationprice;

class BookingTest extends WebTestCase
{
	
	public function testSetEmail()
    {
        $booking = new Booking();
        $emailBooking = 'grillon.d@gmail.com';
        $booking->setEmail($emailBooking);
        $this->assertEquals('grillon.d@gmail.com', $booking->getEmail());
    }


    public function testTicketNormal()
    {
    	$booking = new Booking();
        $ticket = new Ticket();

        self::bootKernel();
        $this->calculationprice = static::$kernel->getContainer()->get('dg_ticketing.calculationprice');

        $calculationprice = $this->calculationprice;
        // $dateResa = "";
        // $dateNaissance = "";
        // $tarifReduit ="";
        // $durationBooking ="";

        // $booking->setBookingDate($dateResa);
        // $ticket->setBrithDate($dateNaissance);
        // $ticket->setReducedPrice($tarifReduit);
        // $booking->setDurationBooking($durationBooking);

        $this->assertEquals(
                [16,'Billet Tarif Normal'], 
                $calculationprice->tarifBillet(
                    '1987-12-22',
                    '29/11/2017',
                    '0',
                    '1'
                )
            );
    }

    public function testTicketSeniorReduct()
    {
    	$booking = new Booking();
        $ticket = new Ticket();

        self::bootKernel();
        $this->calculationprice = static::$kernel->getContainer()->get('dg_ticketing.calculationprice');

        $calculationprice = $this->calculationprice;

        $this->assertEquals(
                [10,'Billet Tarif Reduit'], 
                $calculationprice->tarifBillet(
                    '1987-12-22',
                    '29/11/2017',
                    '1',
                    '1'
                )
            );
    }


    
}