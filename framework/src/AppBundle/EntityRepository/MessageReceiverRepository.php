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
        $exp = $this->getEntityManager()
            ->createQueryBuilder()->expr();
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('i, m, r')
            ->from('AppBundle:InstantMessage', 'i')
            ->from('AppBundle:MessageReceiver', 'r')
            ->innerJoin('i.message', 'm')
            ->where('i.message = r.message')
            ->andWhere('r.receivers LIKE :receivers');

        if ($received) {
            $query->andWhere($exp->orX('r.received LIKE :received', 'r.received LIKE IS NOT NULL'));
        } else {
            $query->andWhere($exp->orX('r.received NOT LIKE :received', 'r.received IS NULL'));
        }

        return $query->setParameter('received', sprintf("%%\"%s\":true%%", $customer->getId()))
            ->setParameter('receivers', sprintf("%%\"%s\"%%", $customer->getUsername()))
            ->getQuery()
            ->getResult();
    }
}