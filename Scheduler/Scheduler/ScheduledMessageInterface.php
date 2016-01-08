<?php

namespace Scheduler\Scheduler;

use Customer\Customer\CustomerInterface;
use Message\Message\MessageInterface;

/**
 * Interface ScheduledMessageInterface
 *
 * @package Scheduler\Scheduler
 */
interface ScheduledMessageInterface
{
    /**
     * Set the Message Receiver Message relation
     *
     * @param MessageInterface $message
     */
    public function setMessage(MessageInterface $message);

    /**
     * Get the Message Receiver Message relation
     *
     * @return MessageInterface
     */
    public function getMessage();

    /**
     * Set the Message Customer sender
     *
     * @param CustomerInterface $customer
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get the Message Customer sender
     *
     * @return CustomerInterface
     */
    public function getCustomer();

    /**
     * Set Scheduled Message at
     *
     * @param \DateTime $at
     */
    public function setAt($at);

    /**
     * Get Scheduled Message at
     *
     * @return \DateTime
     */
    public function getAt();

    /**
     * Get Scheduled Message status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Update the status
     */
    public function nextStatus();
}