<?php

namespace Message\Email;

use Customer\Customer\CustomerDependantInterface;
use Customer\Customer\CustomerInterface;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageInterface;

/**
 * Class EmailMessage
 *
 * @package Message\Email
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