<?php

namespace Message\Instant;

use Customer\Customer\CustomerDependantInterface;
use Customer\Customer\CustomerInterface;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageInterface;

/**
 * Class InstantMessage
 *
 * @package Message\Instant
 */
class InstantMessage implements CustomerDependantInterface,
    MessageDependantInterface,
    InstantMessageInterface
{
    /**
     * @var string
     */
    protected $room;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * InstantMessage constructor.
     *
     * @param string|null $room
     */
    public function __construct($room = null)
    {
        $this->room = $room;
        if (!$this->room) {
            $this->room = uniqid();
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoom()
    {
        return $this->room;
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
}