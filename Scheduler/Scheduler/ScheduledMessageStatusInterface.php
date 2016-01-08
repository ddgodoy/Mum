<?php

namespace Scheduler\Scheduler;

/**
 * Interface ScheduledMessageStatusInterface
 *
 * @package Scheduler\Scheduler
 */
interface ScheduledMessageStatusInterface
{
    /**
     * Get the status id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get the next status
     *
     * @return ScheduledMessageStatusInterface|null
     */
    public function next();
}