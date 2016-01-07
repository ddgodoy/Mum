<?php

namespace Message\Message;

use Customer\Customer\CustomerInterface;

/**
 * Class EmailMessage
 *
 * @package Message\Message
 */
class EmailMessage implements CustomerDependantInterface,
    MessageDependantInterface,
    EmailMessageInterface
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
     * @var string
     */
    protected $about;

    /**
     * @var string
     */
    protected $fromAddress;

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

    /**
     * @inheritdoc
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * @inheritdoc
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @inheritdoc
     */
    public function setFromAddress($fromAddress)
    {
        $this->fromAddress = $fromAddress;
    }

    /**
     * @inheritdoc
     */
    public function getFromAddress()
    {
        return $this->fromAddress;
    }
}