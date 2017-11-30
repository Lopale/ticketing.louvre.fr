<?php

namespace Tests\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TIcketingControllerTest extends WebTestCase
{
     public function testCommandPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ticketing/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Commander', $crawler->filter('h2')->text());
    }


    
}
