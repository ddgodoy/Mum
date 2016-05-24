<?php

namespace AppBundle\EntityRepository;

use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class InstantMessageRepository
 *
 * @package AppBundle\EntityRepository
 */
class InstantMessageRepository extends EntityRepository implements MessageRepositoryInterface
{
    public function getFrom()
    {
        return ' AppBundle:InstantMessage messageDependant';
    }

    public function getWhere()
    {
        return ' AND schedule.message = messageDependant.message';
    }

    public function findAllByReceived(CustomerInterface $customer, $received = false)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('i, m')
            ->from('AppBundle:InstantMessage', 'i')
            ->innerJoin('i.message', 'm')
            ->where('i.received = :received')
            ->andWhere('m.customer = :customer')
            ->setParameter('received', $received)
            ->setParameter('customer', $customer)
            ->getQuery()
            ->getResult();
    }
}