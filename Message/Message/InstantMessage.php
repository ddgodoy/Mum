<?php

namespace Message\Message;
use Customer\Customer\CustomerInterface;

/**
 * Class InstantMessage
 *
 * @package Message\Message
 */
class InstantMessage implements CustomerDependantInterface,
    MessageDependantInterface,
    InstantMessageInterface
{
    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var MessageInterface
     */
    protected $message;

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