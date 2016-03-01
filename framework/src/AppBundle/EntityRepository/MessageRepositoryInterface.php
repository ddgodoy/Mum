<?php

namespace AppBundle\EntityRepository;

/**
 * Interface MessageRepositoryInterface
 * 
 * @package AppBundle\EntityRepository
 */
interface MessageRepositoryInterface
{
    public function getFrom();

    public function getWhere();
}