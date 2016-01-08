<?php

namespace Scheduler\Scheduler;

/**
 * Class ScheduledMessageStatusProcessing
 *
 * @package Scheduler\Scheduler
 */
class ScheduledMessageStatusProcessing implements ScheduledMessageStatusInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * ScheduledMessageStatusProcessing constructor.
     */
    public function __construct()
    {
        $this->id = 2;
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
        return new ScheduledMessageStatusSent();
    }
}