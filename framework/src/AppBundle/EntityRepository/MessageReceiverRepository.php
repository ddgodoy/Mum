<?php

namespace AppBundle\EntityRepository;

use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class MessageReceiverRepository
 *
 * @package AppBundle\EntityRepository
 */
class MessageReceiverRepository extends EntityRepository
{
    public function findAllByReceived(CustomerInterface $customer, $received = false)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('i, m, r')
            ->from('AppBundle:InstantMessage', 'i')
            ->from('AppBundle:MessageReceiver', 'r')
            ->innerJoin('i.message', 'm')
            ->where('i.message = r.message')
            ->andWhere('r.receivers LIKE :receivers');

        if ($received) {
            $query->andWhere('r.received LIKE :received');
        } else {
            $query->andWhere('r.received NOT LIKE :received');
        }

        return $query->setParameter('received', sprintf("%%\"%s\":true%%", $customer->getId()))
            ->setParameter('receivers', sprintf("%%\"%s\"%%", $customer->getUsername()))
            ->getQuery()
            ->getResult();
    }
}