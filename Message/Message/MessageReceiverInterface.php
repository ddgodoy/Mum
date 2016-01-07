<?php

namespace Message\Message;

use Customer\Customer\CustomerInterface;

/**
 * Interface MessageReceiverInterface
 *
 * @package Message\Message
 */
interface MessageReceiverInterface
{
    /**
     * Get the Message Id
     *
     * @return string
     */
    public function getId();

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
     * Set array of receivers
     *
     * @param array $receivers
     */
    public function setReceivers(Array $receivers);

    /**
     * Get Message receivers
     *
     * @return array
     */
    public function getReceivers();
}