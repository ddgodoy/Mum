<?php

namespace Message\Message;

use Customer\Customer\CustomerInterface;

/**
 * Class MessageReceiver
 *
 * @package Message\Message
 */
class MessageReceiver implements MessageReceiverInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var array
     */
    protected $receivers;

    /**
     * @var array
     */
    protected $received;

    /**
     * MessageReceiver constructor.
     *
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        if (!$this->id) {
            $this->id = uniqid();
        }
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
    public function setReceivers(Array $receivers)
    {
        $this->receivers = $receivers;
    }

    /**
     * @inheritdoc
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    /**
     * @inheritdoc
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * @inheritdoc
     */
    public function addReceived(CustomerInterface $customer)
    {
        $this->received[$customer->getId()] = true;
    }
}