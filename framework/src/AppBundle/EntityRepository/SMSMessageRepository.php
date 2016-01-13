<?php

namespace AppBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SMSMessageRepository
 *
 * @package AppBundle\EntityRepository
 */
class SMSMessageRepository extends EntityRepository
{
    public function getFrom()
    {
        return ' AppBundle:SMSMessage messageDependant';
    }

    public function getWhere()
    {
        return ' AND schedule.message = messageDependant.message';
    }
}