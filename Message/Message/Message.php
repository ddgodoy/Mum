<?php

namespace Message\Message;

use Customer\Customer\CustomerInterface;

/**
 * Class Message
 *
 * @package Message\Message
 */
class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var string
     */
    protected $body;

    /**
     * Message constructor.
     *
     * @param string|null $id
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
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->body;
    }
}