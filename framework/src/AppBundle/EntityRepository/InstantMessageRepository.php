<?php

namespace AppBundle\EntityRepository;

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
}