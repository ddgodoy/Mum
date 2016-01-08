<?php

namespace Scheduler\Scheduler;

/**
 * Class ScheduledMessageStatusSent
 *
 * @package Scheduler\Scheduler
 */
class ScheduledMessageStatusSent implements ScheduledMessageStatusInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * ScheduledMessageStatusSent constructor.
     */
    public function __construct()
    {
        $this->id = 3;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return null;
    }
}