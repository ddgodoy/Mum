<?php

namespace AppBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Class EmailMessageRepository
 *
 * @package AppBundle\EntityRepository
 */
class EmailMessageRepository extends EntityRepository
{
    public function getFrom()
    {
        return ' AppBundle:EmailMessage messageDependant';
    }

    public function getWhere()
    {
        return ' AND schedule.message = messageDependant.message';
    }
}