<?php

namespace Scheduler\Scheduler;

use Customer\Customer\CustomerInterface;
use Message\Message\MessageInterface;

/**
 * Class ScheduledMessage
 *
 * @package Scheduler\Scheduler
 */
class ScheduledMessage implements ScheduledMessageInterface
{
    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var \DateTime
     */
    protected $at;

    /**
     * @var int
     */
    protected $status;

    /**
     * ScheduledMessage constructor.
     */
    public function __construct()
    {
        $this->status = new ScheduledMessageStatusCreated();
    }

    /**
     * @inheritdoc
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @inheritdoc
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @inheritdoc
     */
    public function setAt($at)
    {
        $this->at = $at;
    }

    /**
     * @inheritdoc
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->status->getId();
    }

    /**
     * @inheritdoc
     */
    public function nextStatus()
    {
        $this->status = $this->status->next();
    }
}