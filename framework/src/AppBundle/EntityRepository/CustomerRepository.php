<?php

namespace AppBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CustomerRepository
 *
 * @package AppBundle\EntityRepository
 */
class CustomerRepository extends EntityRepository
{
    /**
     * Get by ids
     *
     * @param array $ids
     * @return mixed
     */
    public function getByIds(Array $ids)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('c')
            ->from('AppBundle:Customer', 'c')
            ->where($qb->expr()->in('c.username', ':ids'))
            ->setParameter(':ids', array_values($ids));

        return $qb->getQuery()->getResult();
    }
}