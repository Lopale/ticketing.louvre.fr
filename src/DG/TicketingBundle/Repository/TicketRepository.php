<?php

namespace DG\TicketingBundle\Repository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends \Doctrine\ORM\EntityRepository
{


	public function nbTicketsAlreadySellBis($visiteDay)
	{
	 // return $this->createQueryBuilder('t')
  //                   ->innerJoin('t.booking', 'booking')
  //                   ->addSelect('booking')
  //                   ->where('booking.visiteDay = :visiteDay')
  //                       ->setParameter('visiteDay', new \DateTime())
  //                   ->getQuery()
  //                   ->getResult();


		$qb = $this->createQueryBuilder('t');

		/* Solution qui marche mais ne compte que les réservations pas les billets */
		// $qb->select('b')
  //           ->from('DGTicketingBundle:Booking', 'b')
  //           ->where('b.visiteDay = :visiteDay')
  //           ->setParameter('visiteDay', $visiteDay)
  //       ;


       $qb ->innerJoin('t.booking', 'booking')
                    ->addSelect('booking')
                    ->where('booking.visiteDay = :visiteDay')
                        ->setParameter('visiteDay', $visiteDay)
        ;

        $result = $qb->getQuery()->getResult();

        //$result =  $result[0];
        //return $result[1];

        return $result;
	}


}
