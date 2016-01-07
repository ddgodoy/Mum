<?php

namespace Message\Message;

/**
 * Interface ScheduledMessageStatusInterface
 *
 * @package Message\Message
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